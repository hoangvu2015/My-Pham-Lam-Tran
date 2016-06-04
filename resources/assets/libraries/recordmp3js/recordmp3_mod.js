(function (window) {

    var WORKER_PATH = RECORDED_MP3_PARENT_PATH + 'recordmp3js/recorderWorker.js';
    var encoderWorker = new Worker(RECORDED_MP3_PARENT_PATH + 'recordmp3js/mp3Worker.js');

    var Recorder = function (source, cfg) {
        var config = cfg || {};
        var bufferLen = config.bufferLen || 4096;
        var numChannels = config.numChannels || 2;
        this.context = source.context;
        this.node = (this.context.createScriptProcessor ||
        this.context.createJavaScriptNode).call(this.context,
            bufferLen, numChannels, numChannels);
        var worker = new Worker(config.workerPath || WORKER_PATH);
        worker.postMessage({
            command: 'init',
            config: {
                sampleRate: this.context.sampleRate,
                numChannels: numChannels
            }
        });
        var recording = false,
            currCallback;

        this.node.onaudioprocess = function (e) {
            if (!recording) return;
            var buffer = [];
            for (var channel = 0; channel < numChannels; channel++) {
                buffer.push(e.inputBuffer.getChannelData(channel));
            }
            worker.postMessage({
                command: 'record',
                buffer: buffer
            });
        }

        this.configure = function (cfg) {
            for (var prop in cfg) {
                if (cfg.hasOwnProperty(prop)) {
                    config[prop] = cfg[prop];
                }
            }
        }

        this.record = function () {
            recording = true;
        }

        this.stop = function () {
            recording = false;
        }

        this.clear = function () {
            worker.postMessage({command: 'clear'});
        }

        this.getBuffer = function (cb) {
            currCallback = cb || config.callback;
            worker.postMessage({command: 'getBuffer'})
        }

        this.exportWAV = function (cb, type) {
            currCallback = cb || config.callback;
            type = type || config.type || 'audio/wav';
            if (!currCallback) throw new Error('Callback not set');
            worker.postMessage({
                command: 'exportWAV',
                type: type
            });
        }

        //Mp3 conversion
        worker.onmessage = function (e) {
            var blob = e.data;
            //console.log("the blob " +  blob + " " + blob.size + " " + blob.type);

            var arrayBuffer;
            var fileReader = new FileReader();

            fileReader.onload = function () {
                arrayBuffer = this.result;
                var buffer = new Uint8Array(arrayBuffer),
                    data = parseWav(buffer);

                console.log(data);
                console.log("Converting to Mp3");

                encoderWorker.postMessage({
                    cmd: 'init', config: {
                        mode: 3,
                        channels: 1,
                        samplerate: data.sampleRate,
                        bitrate: data.bitsPerSample
                    }
                });

                encoderWorker.postMessage({cmd: 'encode', buf: Uint8ArrayToFloat32Array(data.samples)});
                encoderWorker.postMessage({cmd: 'finish'});
                encoderWorker.onmessage = function (e) {
                    if (e.data.cmd == 'data') {

                        console.log("Done converting to Mp3");

                        //var audio = new Audio();
                        //audio.src = 'data:audio/mp3;base64,' + encode64(e.data.buf);
                        //audio.play();

                        var mp3Blob = new Blob([new Uint8Array(e.data.buf)], {type: 'audio/mp3'});
                        var au = document.createElement('audio');
                        au.controls = true;
                        au.src = URL.createObjectURL(mp3Blob);
                        jQuery('#recorded').html(au.outerHTML);
                        uploadAudio(mp3Blob);
                    }
                };
            };

            fileReader.readAsArrayBuffer(blob);

            currCallback(blob);
        }


        function encode64(buffer) {
            var binary = '',
                bytes = new Uint8Array(buffer),
                len = bytes.byteLength;

            for (var i = 0; i < len; i++) {
                binary += String.fromCharCode(bytes[i]);
            }
            return window.btoa(binary);
        }

        function parseWav(wav) {
            function readInt(i, bytes) {
                var ret = 0,
                    shft = 0;

                while (bytes) {
                    ret += wav[i] << shft;
                    shft += 8;
                    i++;
                    bytes--;
                }
                return ret;
            }

            if (readInt(20, 2) != 1) throw 'Invalid compression code, not PCM';
            if (readInt(22, 2) != 1) throw 'Invalid number of channels, not 1';
            return {
                sampleRate: readInt(24, 4),
                bitsPerSample: readInt(34, 2),
                samples: wav.subarray(44)
            };
        }

        function Uint8ArrayToFloat32Array(u8a) {
            var f32Buffer = new Float32Array(u8a.length);
            for (var i = 0; i < u8a.length; i++) {
                var value = u8a[i << 1] + (u8a[(i << 1) + 1] << 8);
                if (value >= 0x8000) value |= ~0x7FFF;
                f32Buffer[i] = value / 0x8000;
            }
            return f32Buffer;
        }

        function uploadAudio(mp3Data) {
            var reader = new FileReader();
            reader.onload = function (event) {
                if (typeof RECORDED_MP3_UPLOAD_URL !== 'undefinded') {
                    var fd = new FormData();
                    var mp3Name = encodeURIComponent('audio_recording_' + new Date().getTime() + '.mp3');
                    console.log("mp3name = " + mp3Name);
                    fd.append('fname', mp3Name);
                    fd.append('data', event.target.result);
                    fd.append('_token', AJAX_REQUEST_TOKEN);
                    $.ajax({
                        type: 'POST',
                        url: RECORDED_MP3_UPLOAD_URL,
                        data: fd,
                        processData: false,
                        contentType: false
                    }).done(function (data) {
                        jQuery('body').trigger(jQuery.Event('recordmp3_uploaded'), [data]);
                    });
                }
            };
            reader.readAsDataURL(mp3Data);
        }

        source.connect(this.node);
        this.node.connect(this.context.destination);    //this should not be necessary
    };

    window.Recorder = Recorder;
})(window);

/**
 * Created by Nguyen Tuan Linh on 2015-11-03.
 */
var audio_context;
var recorder;
var autoStopRecording = RECORDING_AUTO_STOP_AFTER | 0
var stopInterval;

function startUserMedia(stream) {
    var input = audio_context.createMediaStreamSource(stream);
    recorder = new Recorder(input, {
        numChannels: 1
    });
}

function startRecording(button) {
    recorder && recorder.record();
    button.disabled = true;
    var stopButton = button.nextElementSibling;
    stopButton.disabled = false;

    var $recorded = jQuery('#recorded');
    $recorded.html('<img src="' + RECORDING_START_IMAGE + '">');

    if (autoStopRecording > 0) {
        var remainingSeconds = autoStopRecording % 60;
        var remainingMinutes = parseInt(autoStopRecording / 60);
        var prefixContent = '<img src="' + RECORDING_START_IMAGE + '"> &nbsp; ' + RECORDING_STOP_TEXT_AFTER + ' ';
        $recorded.html(prefixContent + toDigits(remainingMinutes) + ':' + toDigits(remainingSeconds));
        stopInterval = setInterval(function () {
            --remainingSeconds;

            if (remainingSeconds < 0) {
                remainingSeconds = 59;
                --remainingMinutes;

                if (remainingMinutes < 0) {
                    clearInterval(stopInterval);
                    stopRecording(stopButton);
                    return;
                }
            }

            $recorded.html(prefixContent + toDigits(remainingMinutes) + ':' + toDigits(remainingSeconds));
        }, 1000);
    }
}

function stopRecording(button) {
    jQuery('#recorded').html('<img src="' + RECORDING_STOP_IMAGE + '"> &nbsp; ' + RECORDING_STOP_TEXT + '...');

    recorder && recorder.stop();
    button.disabled = true;
    createDownloadLink();
    recorder.clear();

    if (autoStopRecording > 0) {
        clearInterval(stopInterval);
    }
}

function createDownloadLink() {
    recorder && recorder.exportWAV(function (blob) {
        var au = document.createElement('audio');
        au.controls = true;
        au.src = URL.createObjectURL(blob);
        jQuery('#recored').html(au.outerHTML);
    });
}

function checkRecordingEnvironment() {
    return Modernizr.webaudio && Modernizr.getusermedia && Modernizr.filereader && Modernizr.url &&
        Modernizr.webworkers && Modernizr.formdata && Modernizr.float32array && Modernizr.uint8array &&
        Modernizr['atob-btoa'];
}

function initRecording() {
    window.AudioContext = window.AudioContext || window.webkitAudioContext;
    navigator.getUserMedia = (
        navigator.getUserMedia ||
        navigator.webkitGetUserMedia ||
        navigator.mozGetUserMedia ||
        navigator.msGetUserMedia
    );
    window.URL = window.URL || window.webkitURL;

    audio_context = new AudioContext;
    navigator.getUserMedia({audio: true}, startUserMedia, function (e) {
        console.log('No live audio input: ' + e);
    });
}