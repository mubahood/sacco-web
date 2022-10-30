<?php

namespace App\Admin\Controllers;

use App\Models\Enterprise;
use Encore\Admin\Auth\Database\Administrator;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class EnterpriseController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Enterprise';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Enterprise());

        $grid->model()->orderBy('id', 'DESC');

        $grid->actions(function ($actions) {
            $actions->disableView();
        });

        $grid->column('id', __('Id'))->sortable();
        $grid->column('name', __('Name'))->sortable();
        $grid->column('administrator_id', __('Onwer'))->display(function () {
            return $this->owner->name;
        });
        $grid->column('logo', __('Logo'));
        $grid->column('short_name', __('Short name'));
        $grid->column('phone_number', __('Phone number'));
        $grid->column('email', __('Email'));
        $grid->column('address', __('Address'))->hide();
        $grid->column('created_at', __('Created'));
        $grid->column('details', __('Details'))->hide();

        return $grid;
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show(Enterprise::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));
        $show->field('name', __('Name'));
        $show->field('short_name', __('Short name'));
        $show->field('details', __('Details'));
        $show->field('logo', __('Logo'));
        $show->field('phone_number', __('Phone number'));
        $show->field('email', __('Email'));
        $show->field('address', __('Address'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Enterprise());

        $ads = [];
     
        $form->select('type', __('Group status'))
            ->options([
                'Pending' => 'Pending',
                'Approved' => 'Approved',
            ])
            ->rules('required');

        $form->select('administrator_id', __('Group owner'))
            ->options(
                $ads
            )
            ->rules('required');

        $form->text('name', __('Group Name'))->required();
        $form->text('short_name', __('Group short name'))->required();
        $form->textarea('details', __('Details about group'))->rules('required');



        $form->quill('welcome_message', __('Group rules'))->required();
        $form->image('logo', __('Group Logo'));
        $form->text('phone_number', __('Group Phone number'))->attribute('type', 'number');
        $form->text('email', __('Group Email'))->attribute('type', 'email')->required();
        $form->text('address', __('Group Address'));


        return $form;
    }
}
