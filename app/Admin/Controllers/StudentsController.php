<?php

namespace App\Admin\Controllers;

use App\Models\AcademicClass;
use App\Models\AcademicYear;
use App\Models\AdminRole;
use App\Models\AdminRoleUser;
use App\Models\StudentHasClass;
use App\Models\Utils;
use Carbon\Carbon;
use Encore\Admin\Auth\Database\Administrator;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;

/*

`first_name` TEXT DEFAULT NULL,
`last_name` TEXT DEFAULT NULL,
`date_of_birth` TEXT DEFAULT NULL,
`place_of_birth` TEXT DEFAULT NULL,
`sex` TEXT DEFAULT NULL,
`home_address` TEXT DEFAULT NULL,
`current_address` TEXT DEFAULT NULL,
`phone_number_1` TEXT DEFAULT NULL,
`phone_number_2` TEXT DEFAULT NULL,
`email` TEXT DEFAULT NULL,
`nationality` TEXT DEFAULT NULL,
`religion` TEXT DEFAULT NULL,
`spouse_name` TEXT DEFAULT NULL,
`spouse_phone` TEXT DEFAULT NULL,
`father_name` TEXT DEFAULT NULL,
`father_phone` TEXT DEFAULT NULL,
`mother_name` TEXT DEFAULT NULL,
`mother_phone` TEXT DEFAULT NULL,
`languages` TEXT DEFAULT NULL,
`emergency_person_name` TEXT DEFAULT NULL,
`emergency_person_phone` TEXT DEFAULT NULL,
`national_id_number` TEXT DEFAULT NULL,
`passport_number` TEXT DEFAULT NULL,
`tin` TEXT DEFAULT NULL,
`nssf_number` TEXT DEFAULT NULL,
`bank_name` TEXT DEFAULT NULL,
`bank_account_number` TEXT DEFAULT NULL,
`primary_school_name` TEXT DEFAULT NULL,
`primary_school_year_graduated` TEXT DEFAULT NULL,
`seconday_school_name` TEXT DEFAULT NULL,
`seconday_school_year_graduated` TEXT DEFAULT NULL,
`high_school_name` TEXT DEFAULT NULL,
`high_school_year_graduated` TEXT DEFAULT NULL,
`degree_university_name` TEXT DEFAULT NULL,
`degree_university_year_graduated` TEXT DEFAULT NULL,
`masters_university_name` TEXT DEFAULT NULL,
`masters_university_year_graduated` TEXT DEFAULT NULL,
`phd_university_name` TEXT DEFAULT NULL,
`phd_university_year_graduated` TEXT DEFAULT NULL,
 


===================================
===================================
===================================
===================================
===================================
===================================
===================================
===================================
PERSONAL INFORMATION
--------------------
- First name
- Last name
- Date of birth
- Place of birth
- Sex
- Home Address
- Current Address
- Telephone
- Cell phone
- Email address
- Cival status
- Citizineship
- Religion
- Spource name
- Spource phone
- Farther's name
- Farther's phone
- Mothers's name
- Mothers's phone
- Languages
- Contact for emergency name
- Contact for emergency phone
- Mothers's phone
- 

ACCOUNT NUMBERS
--------------------
- National ID Number
- Passport number
- TIN Number
- NSSF NUMBER
- Bank name
- Bank account number
- 

EDUCATIONAL INFORMATION
--------------------
- Primary school name
- Primary school year graduated
- Seconday school name
- Seconday school year graduated
- High school name
- High school year graduated
- Degree university name
- Degree university year graduated
- Masters university name
- Masters university year graduated
- PHD university name
- PHD university year graduated
- 

ACCOUNT INFORMATION
--------------------
- Usename
- Password


*/

class StudentsController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Students admissions';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Administrator());

        Utils::display_checklist(Utils::students_checklist(Admin::user()));
        Utils::display_checklist(Utils::students_optional_subjects_checklist(Admin::user()));



        $grid->filter(function ($filter) {

            $filter->between('created_at', 'Admitted')->date();

 
            // Remove the default id filter
            $filter->disableIdFilter();

            // Add a column filter

            //$filter->like('name', 'Search by name');

            $u = Admin::user();
            /* $ajax_url = url(
                '/api/ajax?'
                    . 'enterprise_id=' . $u->enterprise_id
                    . "&search_by_1=name"
                    . "&search_by_2=id"
                    . "&model=User"
            );

            $filter->equal('id','Name')->select()->ajax($ajax_url); */
            /*  $filter->whereIn(function ($query) {

                $ids = StudentHasClass::where([
                    'academic_class_id' => ((int)($this->input))
                ])->get()->pluck('id');

                $query->whereIn('id', $ids);
            }, 'Filter by class')->select(
                AcademicClass::where([
                    'enterprise_id' => $u->enterprise_id
                ])->get()->pluck('name_text', 'id')
            ); */




            //$filter->expand();
        });

        $grid->quickSearch('name');

        $grid->model()->where([
            'enterprise_id' => Admin::user()->enterprise_id,
            'user_type' => 'student'
        ]);

        $grid->actions(function ($actions) {
            $actions->disableView();
        });

        $grid->column('id', __('Id'))->sortable();
        $grid->column('name', __('Name'))->sortable();
        $grid->column('phone_number_1', __('Phone number'))->hide();
        $grid->column('phone_number_2', __('Phone number 2'))->hide();
        $grid->column('email', __('Email'));
        $grid->column('date_of_birth', __('D.O.B'))->sortable();
        $grid->column('nationality', __('Nationality'))->sortable();
        $grid->column('sex', __('Sex'))
            ->sortable()
            ->filter(['Male' => 'Male', 'Female' => 'Female']);
        $grid->column('place_of_birth', __('Place of birth'))->sortable();
        $grid->column('home_address', __('Home address'))->hide();
        $grid->column('current_address', __('Current address'))->hide();
        $grid->column('religion', __('Religion'))->hide();
        $grid->column('spouse_name', __('Spouse name'))->hide();
        $grid->column('spouse_phone', __('Spouse phone'))->hide();
        $grid->column('father_name')->hide();
        $grid->column('father_phone')->hide();
        $grid->column('mother_name')->hide();
        $grid->column('mother_phone')->hide();
        $grid->column('languages')->hide();
        $grid->column('emergency_person_name')->hide();
        $grid->column('emergency_person_phone')->hide();
        $grid->column('national_id_number', 'N.I.N')->hide();
        $grid->column('passport_number')->hide();
        $grid->column('tin', 'TIN')->hide();
        $grid->column('nssf_number')->hide();
        $grid->column('bank_name')->hide();
        $grid->column('bank_account_number')->hide();
        //$grid->column('primary_school_name')->hide();
        //$grid->column('primary_school_year_graduated')->hide();
        //$grid->column('seconday_school_name')->hide();
        //$grid->column('seconday_school_year_graduated')->hide();
        //$grid->column('high_school_name')->hide();
        //$grid->column('high_school_year_graduated')->hide();
        //$grid->column('degree_university_name')->hide();
        //$grid->column('degree_university_year_graduated')->hide();
        //$grid->column('masters_university_name')->hide();
        //$grid->column('masters_university_year_graduated')->hide();
        //$grid->column('phd_university_name')->hide();
        //$grid->column('phd_university_year_graduated')->hide();

        $grid->column('created_at', __('Admitted'))
            ->display(function ($date) {
                return Carbon::parse($date)->format('d-M-Y');
            })->sortable();

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
        $show = new Show(Administrator::findOrFail($id));
        $show->field('id', __('Id'));
        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $u = Admin::user();

        $form = new Form(new Administrator());




        $form->tab('BIO DATA', function (Form $form) {

            $u = Admin::user();
            $form->hidden('enterprise_id')->rules('required')->default($u->enterprise_id)
                ->value($u->enterprise_id);

            $form->hidden('user_type')->default('student')->value('student')->updateRules('required|max:223');

            $form->text('first_name')->rules('required');
            $form->text('last_name')->rules('required');
            $form->date('date_of_birth')->rules('required');
            $form->text('place_of_birth');
            $form->select('sex')->options(['Male' => 'Male', 'Female' => 'Female'])->rules('required');
            $form->text('home_address');
            $form->text('current_address');
            $form->text('phone_number_1', 'Mobile phone number')->rules('required');
            $form->text('phone_number_2', 'Home phone number');
            $form->text('nationality');
        })->tab('PERSONAL INFORMATION', function (Form $form) {
            $form->text('religion');

            $form->text('father_name', "Father's name");
            $form->text('father_phone', "Father's phone number");
            $form->text('mother_name', "Mother's name");
            $form->text('mother_phone', "Mother's phone number");
            $form->text('languages', "Languages/Dilect");
            $form->text('emergency_person_name', "Emergency person to contact name");
            $form->text('emergency_person_phone', "Emergency person to contact phone number");
        })
            ->tab('CLASS ALLOCATION', function (Form $form) {
                $form->morphMany('classes', 'Click on new to add this student to a class', function (Form\NestedForm $form) {
                    $u = Admin::user();
                    $form->hidden('enterprise_id')->default($u->enterprise_id);


                    $form->select('academic_class_id', 'Class')->options(function () {
                        return AcademicClass::where([
                            'enterprise_id' => Admin::user()->enterprise_id,
                        ])->get()->pluck('name', 'id');
                    })
                        ->rules('required')->load(
                            'stream_id',
                            url('/api/streams?enterprise_id=' . $u->enterprise_id)
                        );
                });
            })
            /* ->tab('ACCOUNT NUMBERS', function (Form $form) {

                $form->text('national_id_number', 'National ID number');
                $form->text('passport_number', 'Passport number');
                $form->text('tin', 'TIN Number');
                $form->text('nssf_number', 'NSSF number');
                $form->text('bank_name');
                $form->text('bank_account_number');
            }) */

            ->tab('SYSTEM ACCOUNT', function (Form $form) {

                $roleModel = config('admin.database.roles_model');
                $form->multipleSelect('roles', trans('admin.roles'))
                    ->attribute([
                        'autocomplete' => 'off'
                    ])
                    ->default([4])
                    ->value([4])
                    ->readonly()
                    ->options(
                        AdminRole::where('slug', '!=', 'super-admin')
                            ->where('slug', '!=', 'admin')
                            ->get()
                            ->pluck('name', 'id')
                    )->rules('required');

                $form->image('avatar', 'Student\'s photo');

                $form->email('email', 'Email address')
                    ->creationRules(['required', "unique:admin_users"])
                    ->updateRules(['required', "unique:admin_users,username,{{id}}"]);
                $form->text('username', 'Username')
                    ->creationRules(['required', "unique:admin_users"])
                    ->updateRules(['required', "unique:admin_users,username,{{id}}"]);

                $form->password('password', trans('admin.password'))->rules('required|confirmed');
                $form->password('password_confirmation', trans('admin.password_confirmation'))->rules('required')
                    ->default(function ($form) {
                        return $form->model()->password;
                    });

                $form->ignore(['password_confirmation']);
                $form->saving(function (Form $form) {
                    if ($form->password && $form->model()->password != $form->password) {
                        $form->password = Hash::make($form->password);
                    }
                });
            });




        return $form;
    }
}
