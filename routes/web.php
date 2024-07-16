<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\QueryController;
use App\Http\Controllers\dashboard\Analytics;
use App\Http\Controllers\user_management\UserManagement;
use App\Http\Controllers\company_management\CompanyManagement;
use App\Http\Controllers\job_company_management\JobCompanyManagement;
use App\Http\Controllers\job_list\JobList;
use App\Http\Controllers\candidate\Candidate;
use App\Http\Controllers\messages\Messages;
use App\Http\Controllers\blogs\Blogs;
use App\Http\Controllers\layouts\WithoutMenu;
use App\Http\Controllers\layouts\WithoutNavbar;
use App\Http\Controllers\layouts\Fluid;
use App\Http\Controllers\layouts\Container;
use App\Http\Controllers\layouts\Blank;
use App\Http\Controllers\pages\AccountSettingsAccount;
use App\Http\Controllers\pages\AccountSettingsNotifications;
use App\Http\Controllers\pages\AccountSettingsConnections;
use App\Http\Controllers\pages\MiscError;
use App\Http\Controllers\pages\MiscUnderMaintenance;
use App\Http\Controllers\authentications\LoginBasic;
use App\Http\Controllers\authentications\RegisterBasic;
use App\Http\Controllers\authentications\ForgotPasswordBasic;
use App\Http\Controllers\authentications\NewPassword;
use App\Http\Controllers\blog_categories\BlogCategories;
use App\Http\Controllers\cards\CardBasic;
use App\Http\Controllers\master\categories\Categories;
use App\Http\Controllers\user_interface\Accordion;
use App\Http\Controllers\user_interface\Alerts;
use App\Http\Controllers\user_interface\Badges;
use App\Http\Controllers\user_interface\Buttons;
use App\Http\Controllers\user_interface\Carousel;
use App\Http\Controllers\user_interface\Collapse;
use App\Http\Controllers\user_interface\Dropdowns;
use App\Http\Controllers\user_interface\Footer;
use App\Http\Controllers\user_interface\ListGroups;
use App\Http\Controllers\user_interface\Modals;
use App\Http\Controllers\user_interface\Navbar;
use App\Http\Controllers\user_interface\Offcanvas;
use App\Http\Controllers\user_interface\PaginationBreadcrumbs;
use App\Http\Controllers\user_interface\Progress;
use App\Http\Controllers\user_interface\Spinners;
use App\Http\Controllers\user_interface\TabsPills;
use App\Http\Controllers\user_interface\Toasts;
use App\Http\Controllers\user_interface\TooltipsPopovers;
use App\Http\Controllers\user_interface\Typography;
use App\Http\Controllers\extended_ui\PerfectScrollbar;
use App\Http\Controllers\extended_ui\TextDivider;
use App\Http\Controllers\icons\Boxicons;
use App\Http\Controllers\form_elements\BasicInput;
use App\Http\Controllers\form_elements\InputGroups;
use App\Http\Controllers\form_layouts\VerticalForm;
use App\Http\Controllers\form_layouts\HorizontalForm;
use App\Http\Controllers\master\industries\Industries;
use App\Http\Controllers\master\job_levels\JobLevels;
use App\Http\Controllers\master\skills\Skills;
use App\Http\Controllers\master\tech_stacks\TechStacks;
use App\Http\Controllers\master\type_employments\TypeEmployments;
use App\Http\Controllers\tables\Basic as TablesBasic;

// authentication
Route::get('/auth/login', [LoginBasic::class, 'index'])->name('auth-login');
Route::get('/auth/register-basic', [RegisterBasic::class, 'index'])->name('auth-register-basic');
Route::get('/auth/forgot-password', [ForgotPasswordBasic::class, 'index'])->name('auth-reset-password-basic');
Route::get('/auth/new-password', [NewPassword::class, 'index'])->name('auth-new-password');
Route::post('/auth/reset-password-request', [ForgotPasswordBasic::class, 'passwordRequest'])->name('auth-reset-password-request');
Route::post('/auth/reset-password-submit', [ForgotPasswordBasic::class, 'passwordSubmit'])->name('auth-reset-password-submit');
Route::post('/auth/authenticate', [LoginBasic::class, 'authenticate'])->name('auth-authenticate');
Route::get('/auth/logout', [LoginBasic::class, 'logout'])->name('auth-logout');

//Query
Route::post('/query', [QueryController::class, 'query'])->name('query-controller-query');
Route::post('/query-with-attachment', [QueryController::class, 'queryWithAttachment'])->name('query-controller-query-with-attachment');

Route::group(['middleware' => 'authsession'], function () {
    // Routes accessible for both Superadmin and Admin
    // Main Page Route
    Route::get('/', [Analytics::class, 'index'])->name('dashboard-analytics');

    // User Management Route
    Route::get('/user-management', [UserManagement::class, 'index'])->name('user-management');
    Route::get('/user-management/delete', [UserManagement::class, 'delete'])->name('user-management--delete');

    // Company Management Route
    Route::get('/company-management', [CompanyManagement::class, 'index'])->name('company-management');
    Route::get('/company-management/remove', [CompanyManagement::class, 'remove'])->name('company-management--remove');
    Route::get('/company-management/banned', [CompanyManagement::class, 'banned'])->name('company-management--banned');

    // Job Company Management Route
    Route::get('/company-details/{slug}', [JobCompanyManagement::class, 'index'])->name('job-company-management');
    Route::get('/company-details/delete/{slug}', [JobCompanyManagement::class, 'delete'])->name('job-company-management--delete');

    // Job List Route
    Route::get('/job-list', [JobList::class, 'index'])->name('job-list');
    Route::get('/job-list/details/{slug}', [JobList::class, 'details'])->name('job-list--details');
    Route::get('/job-list/delete', [JobList::class, 'delete'])->name('job-list--delete');

    // Candidate Management Route
    Route::get('/candidate', [Candidate::class, 'index'])->name('candidate');
    Route::get('/candidate-details/{slug}', [Candidate::class, 'details'])->name('candidate-details');

    // Messages Route
    Route::get('/customer-support', [Messages::class, 'index'])->name('messages');
    Route::post('/customer-support/reply', [Messages::class, 'reply'])->name('messages-reply');

    // Blogs Route    
    Route::get('/blogs', [Blogs::class, 'index'])->name('blogs');
    Route::get('/blog-details/{slug}', [Blogs::class, 'details'])->name('blog-details');
    Route::post('/blogs/add', [Blogs::class, 'store'])->name('blog-add');
    Route::post('/blog/update', [Blogs::class, 'update'])->name('blog-update');
    Route::get('/blogs/delete', [Blogs::class, 'delete'])->name('blog-delete');

    // Blog Categories Route
    Route::get('/blog-categories', [BlogCategories::class, 'index'])->name('blog-categories');
    Route::post('/blog-categories/store', [BlogCategories::class, 'store'])->name('blog-categories--create/update');
    Route::get('/blog-categories/delete', [BlogCategories::class, 'delete'])->name('blog-categories--delete');


    // Routes accessible only to superadmins
    Route::group(['middleware' => 'superadmin'], function () {
        // User Management Route
        Route::post('/user-management/create', [UserManagement::class, 'store'])->name('user-management--create');
        Route::post('/user-management/update', [UserManagement::class, 'update'])->name('user-management--update');
    });

    //Master Categories Route
    Route::get('/master-categories', [Categories::class, 'index'])->name('master-categories');
    Route::post('/master-categories/store', [Categories::class, 'store'])->name('master-categories--create');
    Route::get('/master-categories/delete', [Categories::class, 'delete'])->name('master-categories--delete');

    //Master JobLevels Route
    Route::get('/master-job-levels', [JobLevels::class, 'index'])->name('master-job-levels');
    Route::post('/master-job-levels/store', [JobLevels::class, 'store'])->name('master-job-levels--create');
    Route::get('/master-job-levels/delete', [JobLevels::class, 'delete'])->name('master-job-levels--delete');

    //Master Skills Route
    Route::get('/master-skills', [Skills::class, 'index'])->name('master-skills');
    Route::post('/master-skills/store', [Skills::class, 'store'])->name('master-skills--create');
    Route::get('/master-skills/delete', [Skills::class, 'delete'])->name('master-skills--delete');

    //Master Tech Stacks Route
    Route::get('/master-tech-stacks', [TechStacks::class, 'index'])->name('master-tech-stacks');
    Route::post('/master-tech-stacks/store', [TechStacks::class, 'store'])->name('master-tech-stacks--create');
    Route::get('/master-tech-stacks/delete', [TechStacks::class, 'delete'])->name('master-tech-stacks--delete');

    //Master Type Employments Route
    Route::get('/master-type-employments', [TypeEmployments::class, 'index'])->name('master-type-employments');
    Route::post('/master-type-employments/store', [TypeEmployments::class, 'store'])->name('master-type-employments--create');
    Route::get('/master-type-employments/delete', [TypeEmployments::class, 'delete'])->name('master-type-employments--delete');

    //Master Type Industries Route
    Route::get('/master-industries', [Industries::class, 'index'])->name('master-industries');
    Route::post('/master-industries/store', [Industries::class, 'store'])->name('master-industries--create');
    Route::get('/master-industries/delete', [Industries::class, 'delete'])->name('master-industries--delete');
});

// layout
Route::get('/layouts/without-menu', [WithoutMenu::class, 'index'])->name('layouts-without-menu');
Route::get('/layouts/without-navbar', [WithoutNavbar::class, 'index'])->name('layouts-without-navbar');
Route::get('/layouts/fluid', [Fluid::class, 'index'])->name('layouts-fluid');
Route::get('/layouts/container', [Container::class, 'index'])->name('layouts-container');
Route::get('/layouts/blank', [Blank::class, 'index'])->name('layouts-blank');

// pages
Route::get('/pages/account-settings-account', [AccountSettingsAccount::class, 'index'])->name('pages-account-settings-account');
Route::get('/pages/account-settings-notifications', [AccountSettingsNotifications::class, 'index'])->name('pages-account-settings-notifications');
Route::get('/pages/account-settings-connections', [AccountSettingsConnections::class, 'index'])->name('pages-account-settings-connections');
Route::get('/pages/misc-error', [MiscError::class, 'index'])->name('pages-misc-error');
Route::get('/pages/misc-under-maintenance', [MiscUnderMaintenance::class, 'index'])->name('pages-misc-under-maintenance');

// cards
Route::get('/cards/basic', [CardBasic::class, 'index'])->name('cards-basic');

// User Interface
Route::get('/ui/accordion', [Accordion::class, 'index'])->name('ui-accordion');
Route::get('/ui/alerts', [Alerts::class, 'index'])->name('ui-alerts');
Route::get('/ui/badges', [Badges::class, 'index'])->name('ui-badges');
Route::get('/ui/buttons', [Buttons::class, 'index'])->name('ui-buttons');
Route::get('/ui/carousel', [Carousel::class, 'index'])->name('ui-carousel');
Route::get('/ui/collapse', [Collapse::class, 'index'])->name('ui-collapse');
Route::get('/ui/dropdowns', [Dropdowns::class, 'index'])->name('ui-dropdowns');
Route::get('/ui/footer', [Footer::class, 'index'])->name('ui-footer');
Route::get('/ui/list-groups', [ListGroups::class, 'index'])->name('ui-list-groups');
Route::get('/ui/modals', [Modals::class, 'index'])->name('ui-modals');
Route::get('/ui/navbar', [Navbar::class, 'index'])->name('ui-navbar');
Route::get('/ui/offcanvas', [Offcanvas::class, 'index'])->name('ui-offcanvas');
Route::get('/ui/pagination-breadcrumbs', [PaginationBreadcrumbs::class, 'index'])->name('ui-pagination-breadcrumbs');
Route::get('/ui/progress', [Progress::class, 'index'])->name('ui-progress');
Route::get('/ui/spinners', [Spinners::class, 'index'])->name('ui-spinners');
Route::get('/ui/tabs-pills', [TabsPills::class, 'index'])->name('ui-tabs-pills');
Route::get('/ui/toasts', [Toasts::class, 'index'])->name('ui-toasts');
Route::get('/ui/tooltips-popovers', [TooltipsPopovers::class, 'index'])->name('ui-tooltips-popovers');
Route::get('/ui/typography', [Typography::class, 'index'])->name('ui-typography');

// extended ui
Route::get('/extended/ui-perfect-scrollbar', [PerfectScrollbar::class, 'index'])->name('extended-ui-perfect-scrollbar');
Route::get('/extended/ui-text-divider', [TextDivider::class, 'index'])->name('extended-ui-text-divider');

// icons
Route::get('/icons/boxicons', [Boxicons::class, 'index'])->name('icons-boxicons');

// form elements
Route::get('/forms/basic-inputs', [BasicInput::class, 'index'])->name('forms-basic-inputs');
Route::get('/forms/input-groups', [InputGroups::class, 'index'])->name('forms-input-groups');

// form layouts
Route::get('/form/layouts-vertical', [VerticalForm::class, 'index'])->name('form-layouts-vertical');
Route::get('/form/layouts-horizontal', [HorizontalForm::class, 'index'])->name('form-layouts-horizontal');

// tables
Route::get('/tables/basic', [TablesBasic::class, 'index'])->name('tables-basic');
