<?php
/**
 * Created by PhpStorm.
 * User: Nguyen Tuan Linh
 * Date: 2015-10-30
 * Time: 10:36
 */

namespace Antoree\Models\Themes\LearningApp\Plugins\FeaturedTeachers;

use Antoree\Models\Review;
use Antoree\Models\Teacher;
use Antoree\Models\Themes\LearningApp\Theme;
use Antoree\Models\Plugins\DefaultWidget\Widget as DefaultWidget;

class Widget extends DefaultWidget
{
    const WIDGET_NAME = 'featured_teachers';
    const WIDGET_DISPLAY_NAME = 'Featured Teachers';
    const THEME_NAME = Theme::NAME;

    public function render()
    {
        return $this->getTemplateRender([
            'name' => $this->name,
            'description' => $this->description,
            'teachers' => $this->teachers(),
            'max_rate' => Review::MAX_RATE,
        ]);
    }

    protected function __initAdminViewParams()
    {
        $teachers = Teacher::publicizable()->orderBy('created_at', 'desc')->get();
        $this->setViewParams([
            'teachers' => $teachers,
            'teacher_ids' => $this->teacherIds(),
        ]);
    }

    public function teachers()
    {
        return Teacher::whereIn('id', $this->teacherIds())->get();
    }

    public function teacherIds()
    {
        return empty($this->data['teacher_ids']) ? [] : $this->data['teacher_ids'];
    }

    public function fields()
    {
        return array_merge(parent::fields(), [
            'teacher_ids'
        ]);
    }

    public function validationRules()
    {
        return array_merge(parent::validationRules(), [
            'teacher_ids' => 'required|array|exists:teachers,id',
        ]);
    }

}