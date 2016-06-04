<!DOCTYPE html>
<html lang="">
<head>
	<meta charset="utf-8">
</head>
<body>
	<p> - Thông tin cũ:</p>
	<ul type="circle">
		<li>Place of residence: {{ $old_data["Place_of_residence"] }}</li>
		@foreach($old_data["bank"] as $bank_key_old => $bank_value_old)
		<li>{{ $bank_key_old }} : 
			<ul type="square">
				@foreach($bank_value_old as $key_payment_old => $value_payment_old)
				@if($value_payment_old != "")
				<li>
					<span style=" text-transform: capitalize;">{{ str_replace("_", " ", $key_payment_old) }}</span> : {{ $value_payment_old }}
				</li>
				@endif
				@endforeach
			</ul>
		</li>
		@endforeach
	</ul>

	<p> - Thông tin mới:</p>
	<ul type="circle">
		<li> Place of residence: {{ $new_data["Place_of_residence"] }}</li>
		@foreach($new_data["bank"] as $bank_key_new => $bank_value_new)
		<li> {{ $bank_key_new }} :
			<ul type="square">
				@foreach($bank_value_new as $key_payment_new => $value_payment_new)
				@if($value_payment_new != "")
				<li>
					<span style=" text-transform: capitalize;">{{ str_replace("_", " ", $key_payment_new) }}</span> : {{ $value_payment_new }}
				</li>
				@endif
				@endforeach
			</ul>
		</li>
		@endforeach
	</ul>
</body>
</html>