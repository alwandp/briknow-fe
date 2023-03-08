<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;
use App\Http\Controllers\CommunicationController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
// \URL::forceScheme('https');

Route::post('/', 'HomeController@indexPOST')->name('home.loginviabristars')->withoutMiddleware([\App\Http\Middleware\VerifyCsrfToken::class]); // add sini

// yang sudah login
Route::middleware('AfterLoginMiddleware')->group(function(){
    Route::get('/', 'HomeController@index')->name('home');
    #editprofile
    Route::post('/editprof', 'HomeController@editprof')->name('home.editprof');
    #HOME
        Route::get('/tpvend', 'HomeController@topfive_vendor')->name('home.topfive_vendor');
        Route::get('/tpproj', 'HomeController@topfive_project')->name('home.topfive_project');
        Route::get('/suggestjax/{key}', 'HomeController@suggest')->name('suggest');
        Route::get('/profile', 'HomeController@profile')->name('home.profile');
        Route::get('/profile/avatar', 'HomeController@avatar')->name('home.achievement');
        Route::get('/profile/{pn}', 'HomeController@profileuser')->name('home.profileuser');
        Route::post('/changeavatar' ,'HomeController@changeavatar')->name('home.changeavatar');
        Route::get('/cntlessontahap', 'HomeController@cntLessonByTahap')->name('home.cntLessonByTahap');
        Route::get('/cntstrainitiative', 'HomeController@cntStraInitiative')->name('home.cntStraInitiative');
        Route::get('/cntcominitiative', 'HomeController@cntComInitiative')->name('home.cntComInitiative');
        Route::get('/cntlimplementation', 'HomeController@cntImplementation')->name('home.cntImplementation');
    #---

    #export
    Route::get('/ex/proyektop5', 'LaporanController@proyektop5')->name('laporan.proyektop5');
    Route::get('/ex/proyektop5pdf', 'LaporanController@proyektop5pdf')->name('laporan.proyektop5pdf');
    Route::get('/ex/vendortop5', 'LaporanController@vendortop5')->name('laporan.vendortop5');
    Route::get('/ex/vendortop5pdf', 'LaporanController@vendortop5pdf')->name('laporan.vendortop5pdf');
    Route::get('/ex/lessontop5', 'LaporanController@lessontop5')->name('laporan.lessontop5');
    Route::get('/ex/lessontop5pdf', 'LaporanController@lessontop5pdf')->name('laporan.lessontop5pdf');
    Route::get('/ex/cominittop5', 'LaporanController@comInittop5')->name('laporan.cominittop5');
    Route::get('/ex/cominittop5pdf', 'LaporanController@comInittop5pdf')->name('laporan.cominittop5pdf');
    Route::get('/ex/strategictop5', 'LaporanController@strategictop5')->name('laporan.strategictop5');
    Route::get('/ex/strategictop5pdf', 'LaporanController@strategictop5pdf')->name('laporan.strategictop5pdf');
    Route::get('/ex/imptop5', 'LaporanController@imptop5')->name('laporan.imptop5');
    Route::get('/ex/imptop5pdf', 'LaporanController@imptop5pdf')->name('laporan.imptop5pdf');
    Route::get('/ex/initiativemost', 'LaporanController@initiativemost')->name('laporan.initiativemost');
    Route::get('/ex/initiativemost5pdf', 'LaporanController@initiativemost5pdf')->name('laporan.initiativemost5pdf');
    Route::get('/ex/strategicmost', 'LaporanController@strategicmost')->name('laporan.strategicmost');
    Route::get('/ex/strategicmost5pdf', 'LaporanController@strategicmost5pdf')->name('laporan.strategicmost5pdf');
    Route::get('/ex/implementationmost', 'LaporanController@implementationmost')->name('laporan.implementationmost');
    Route::get('/ex/implementationmost5pdf', 'LaporanController@implementationmost5pdf')->name('laporan.implementationmost5pdf');
    Route::get('/ex/allexcel', 'LaporanController@allexcel')->name('laporan.allexcel');
    Route::get('/ex/allpdf', 'LaporanController@allpdf')->name('laporan.allpdf');
    Route::get('/ex/alldataexcel', 'LaporanController@allDataexcel')->name('laporan.alldataexcel');
    Route::get('/ex/alldatapdf', 'LaporanController@allDatapdf')->name('laporan.alldatapdf');
    Route::get('/ex/allcommunicationsupportexcel', 'LaporanController@allComSupportexcel')->name('laporan.allcommunicationsupportexcel');
    Route::get('/ex/allcommunicationsupportpdf', 'LaporanController@allComSupportpdf')->name('laporan.allcommunicationsupportpdf');

    #GAMIFICATION
        Route::get('/gamification', 'HomeController@gamification')->name('home.game');
        Route::get('/managegamification', 'Admin\DashboardController@managegamification')->name('managegamification')->middleware('IsAdmin');
        Route::get('/managegamification/edit', 'Admin\DashboardController@managegamification_edit')->name('managegamification_edit')->middleware('IsAdmin');
        Route::get('/manageforum', 'Admin\DashboardController@manageforum')->name('manageforum')->middleware('IsAdmin');//redirect
        Route::get('/manageforum/all', 'Admin\DashboardController@manageforum_all')->name('manageforum_all')->middleware('IsAdmin');
        Route::get('/manageforum/all/{search}','Admin\DashboardController@listall')->name('manageforum_all.listall')->middleware('IsAdmin');
        Route::post('/manageforum/all/remove/{id}','Admin\DashboardController@remove')->name('manageforum_all.remove')->middleware('IsAdmin');
        Route::get('/manageforum/all/sort/public/{search}','Admin\DashboardController@sortPublic')->name('manageforum_all.sortPublic')->middleware('IsAdmin');
        Route::get('/manageforum/all/sort/private/{search}','Admin\DashboardController@sortPrivate')->name('manageforum_all.sortPrivate')->middleware('IsAdmin');
        Route::get('/manageforum/removed', 'Admin\DashboardController@manageforum_removed')->name('manageforum_removed')->middleware('IsAdmin');
        Route::get('/manageforum/removed/{search}','Admin\DashboardController@listremoved')->name('manageforum_removed.listremoved')->middleware('IsAdmin');
        Route::post('/manageforum/removed/restore/{id}','Admin\DashboardController@restore');
        Route::get('/manageforum/removed/sort/public/{search}','Admin\DashboardController@sortPublicRemoved')->name('manageforum_removed.sortPublicRemoved')->middleware('IsAdmin');
        Route::get('/manageforum/removed/sort/private/{search}','Admin\DashboardController@sortPrivateRemoved')->name('manageforum_removed.sortPrivateRemoved')->middleware('IsAdmin');
        Route::post('/gamification/save/level', 'Admin\DashboardController@gamificationsave_level')->name('dashboard.gamesave_level')->middleware('IsAdmin');
        Route::post('/gamification/save/activity', 'Admin\DashboardController@gamificationsave_activity')->name('dashboard.gamesave_activity')->middleware('IsAdmin');
        Route::post('/gamification/save/achievement', 'Admin\DashboardController@gamificationsave_achievement')->name('dashboard.gamesave_achievement')->middleware('IsAdmin');
    #---

    #DASHBOARD - INDEX
        Route::get('/dashboard', 'Admin\DashboardController@redirect')->name('dashboard')->middleware('IsAdmin');
        Route::get('/dashboard/performance', 'Admin\DashboardController@performance')->name('dashboard.performance')->middleware('IsAdmin');
        Route::get('/dashboard/alldata', 'Admin\DashboardController@alldata')->name('dashboard.alldata')->middleware('IsAdmin');
        Route::get('/dashboard/comsumport', 'Admin\DashboardController@dashboard_comsuport')->name('dashboard.comsuport')->middleware('IsAdmin');
        Route::get('/dashboard/getalldata', 'Admin\DashboardController@getalldata')->name('getalldata')->middleware('IsAdmin');
        Route::get('/dashboard/getprojectvisitor', 'Admin\DashboardController@getProjectVisitor')->name('getprojectvisitor')->middleware('IsAdmin');
        Route::get('/dashboard/getprojectconsultant', 'Admin\DashboardController@getprojectConsultant')->name('getprojectconsultant')->middleware('IsAdmin');
        Route::get('/dashboard/getprojectdivisi', 'Admin\DashboardController@getprojectDivisi')->name('getprojectdivisi')->middleware('IsAdmin');
        Route::get('/dashboard/getprojecttahun', 'Admin\DashboardController@getprojectTahun')->name('getprojecttahun')->middleware('IsAdmin');
        #laporan
        Route::get('/dashboard/exxltagspopuler', 'Admin\LaporanController@exxltagspopuler')->name('dashboard.exxltagspopuler')->middleware('IsAdmin');
        Route::get('/dashboard/expdftagspopuler', 'Admin\LaporanController@expdftagspopuler')->name('dashboard.expdftagspopuler')->middleware('IsAdmin');
        Route::get('/dashboard/exxlpertahun', 'Admin\LaporanController@exxlpertahun')->name('dashboard.exxlpertahun')->middleware('IsAdmin');
        Route::get('/dashboard/expdfpertahun', 'Admin\LaporanController@expdfpertahun')->name('dashboard.expdfpertahun')->middleware('IsAdmin');
        Route::get('/dashboard/exxlprojectvisitor', 'Admin\LaporanController@getProjectVisitor')->name('dashboard.exxlprojectvisitor')->middleware('IsAdmin');
        Route::get('/dashboard/expdfprojectvisitor', 'Admin\LaporanController@getpdfProjectVisitor')->name('dashboard.expdfprojectvisitor')->middleware('IsAdmin');
        Route::get('/dashboard/exxlprojectkonsultant', 'Admin\LaporanController@getProjectKonsultant')->name('dashboard.exxlprojectkonsultant')->middleware('IsAdmin');
        Route::get('/dashboard/expdfprojectkonsultant', 'Admin\LaporanController@getpdfProjectKonsultant')->name('dashboard.expdfprojectkonsultant')->middleware('IsAdmin');
        Route::get('/dashboard/exxlprojectdivisi', 'Admin\LaporanController@getProjectDivisi')->name('dashboard.exxlprojectdivisi')->middleware('IsAdmin');
        Route::get('/dashboard/expdfprojectdivisi', 'Admin\LaporanController@getpdfProjectDivisi')->name('dashboard.expdfprojectdivisi')->middleware('IsAdmin');

        #------
    #---

    #DASHBOARD - MANAGEMENT USER
        Route::get('/searchuser', 'ManageUserController@searchuser')->name('searchUser');
        Route::get('/manageuser', 'ManageUserController@index')->name('manage_user')->middleware('IsAdmin');
        Route::get('/manageuser/list_admin/{search}/{page}', 'ManageUserController@list_admin')->name('manage_user.list_admin')->middleware('IsAdmin');
        Route::post('/manageuser/admin/create', 'ManageUserController@admin_create')->name('admin_create')->middleware('IsAdmin');
        Route::post('/manageuser/edit/{id}', 'ManageUserController@edit')->name('editmu')->middleware('IsAdmin');
        Route::delete('/manageuser/destroy/{id}','ManageUserController@hapus')->name('manageuser.hapus')->middleware('IsAdmin');
        Route::get('/user/{search}/{page}', 'ManageUserController@listuser')->name('list_user')->middleware('IsAdmin');
    #---

    #DASHBOARD - MANAGEMENT UKER
        Route::get('/manageuker', 'ManageUkerController@index')->name('manage_uker')->middleware('IsAdmin');
        Route::get('/manageuker/create/', 'ManageUkerController@create')->name('manage_uker.create')->middleware('IsAdmin');
        Route::post('/manageuker/create/proses', 'ManageUkerController@create_proses')->name('manage_uker.create_proses')->middleware('IsAdmin');
        Route::post('/manageuker/edit/{id}', 'ManageUkerController@edit')->name('manage_uker.update')->middleware('IsAdmin');
        Route::get('/manageuker/detail/{id}','ManageUkerController@detail')->name('manage_uker.detail')->middleware('IsAdmin');
        Route::delete('/manageuker/delete/{id}','ManageUkerController@hapus')->name('manage_uker.hapus')->middleware('IsAdmin');
        Route::get('/manageuker/{sort}/{sort2}/{search}','ManageUkerController@index_content')->name('manage_uker.index_content')->middleware('IsAdmin');

    #---

    #DASHBOARD - MANAGEMENT PROJECT
        Route::get('/manageproject/review', 'Admin\ManageProjectController@review')->name('manage_project.review')->middleware('IsAdmin');
        Route::get('/manageproject/review/sort/{key}', 'Admin\ManageProjectController@sort')->name('manage_project.sort')->middleware('IsAdmin');
        Route::post('/manageproject/passing/{tipe}', 'Admin\ManageProjectController@passing')->name('manage_project.passing')->middleware('IsAdmin');
        Route::get('/manageproject/review/p/sort/{key}', 'Admin\ManageProjectController@sortpass')->name('manage_project.sort.pass')->middleware('IsAdmin');
        Route::get('/manageproject/rekomendasi', 'Admin\ManageProjectController@rekomendasi')->name('manage_project.rekomendasi')->middleware('IsAdmin');
        Route::post('/manageproject/rekomendasi/add/{id}','Admin\ManageProjectController@add')->name('manage_project.add')->middleware('IsAdmin');
        Route::post('/manageproject/rekomendasi/remove/{id}','Admin\ManageProjectController@hapus_rekomendasi')->name('manage_project.hapus_rekomendasi')->middleware('IsAdmin');
        Route::get('/manageproject', 'Admin\ManageProjectController@index')->name('manage_project')->middleware('IsAdmin');
        Route::post('/manageproject/review/publish/{id}','Admin\ManageProjectController@publish')->name('manage_project.publish')->middleware('IsAdmin');
        Route::post('/manageproject/review/unpublish/{id}','Admin\ManageProjectController@unpublish')->name('manage_project.unpublish')->middleware('IsAdmin');
        Route::delete('/manageproject/review/destroy/{id}','Admin\ManageProjectController@hapus')->name('manage_project.hapus')->middleware('IsAdmin');
        Route::delete('/manageproject/strategic/destroy/{id}','Admin\ManageProjectController@hapusContentByProject')->name('manage_project.hapuscontent')->middleware('IsAdmin');
        Route::get('/manageproject/review/{fil_div}/{fil_kon}/{search}','Admin\ManageProjectController@review_content')->middleware('IsAdmin');
    #---

    #Dashboard - Management Lesson Learned
        Route::get('/managelesson/review', 'Admin\ManageLessonLearned@review')->name('manage_lesson.review')->middleware('IsAdmin');
        Route::get('/managelesson', 'Admin\ManageLessonLearned@index')->name('manage_lesson')->middleware('IsAdmin');

    #Dashboard - Management Communication Support
    Route::get('/managecommunication/communicationinitiative/{type}', 'Admin\ManageComSupport@comInitType')->name('com_init.type')->middleware('IsAdmin');
    Route::get('/managecommunication/communicationinitiative', 'Admin\ManageComSupport@communicationInitiative')->name('manage_com.com_init')->middleware('IsAdmin');
    Route::get('/managecommunication', 'Admin\ManageComSupport@index')->name('manage_com')->middleware('IsAdmin');
    Route::get('/managecommunication/upload/{type}/{slug?}', 'Admin\ManageComSupport@uploadForm')->name('manage_com.upload_form')->middleware('IsAdmin');
    Route::post('/managecommunication/upload/content', 'Admin\ManageComSupport@createComInit')->name('manage_com.create')->middleware('IsAdmin');
    Route::get('/communicationinitiative/{type}', 'Admin\ManageComSupport@getAllComInitiative')->name('com_init.get_type')->middleware('IsAdmin');
    Route::post('/communicationinitiative/status/{status}/{id}', 'Admin\ManageComSupport@setStatusComInit')->name('con_init.set_status')->middleware('IsAdmin');
    Route::delete('/communicationinitiative/delete/{id}', 'Admin\ManageComSupport@deleteComInit')->name('con_init.delete')->middleware('IsAdmin');
    #--
    Route::get('/managecommunication/strategicinitiative', 'Admin\ManageComSupport@strategic')->name('manage_com.strategic')->middleware('IsAdmin');
    Route::get('/managecommunication/strategicinitiative/project/{slug}', 'Admin\ManageComSupport@strategicByProject')->name('manage_com.strategicbyproject')->middleware('IsAdmin');
    Route::get('/managecommunication/strategicinitiative/project/{slug}/{type}', 'Admin\ManageComSupport@strategicByType')->name('manage_com.strategicbyprojectandtype')->middleware('IsAdmin');
    Route::get('/get/strategicinitiative', 'Admin\ManageComSupport@getAllStrategicInitiative')->name('strategic_init.get_all')->middleware('IsAdmin');
    Route::get('/get/strategicinitiative/project/{slug}/{type}', 'Admin\ManageComSupport@getAllStrategicInitiativeByProjectAndType')->name('strategic_init.get_allbytype')->middleware('IsAdmin');
    Route::get('/get/strategicinitiative/project/{slug}', 'Admin\ManageComSupport@getAllStrategicByProject')->name('strategic_init.get_allbyproject')->middleware('IsAdmin');
    #--
    Route::get('/managecommunication/implementation/{step}', 'Admin\ManageComSupport@implementationStepTus')->name('implementation.steptus')->middleware('IsAdmin');
    Route::get('/managecommunication/implementation', 'Admin\ManageComSupport@implementation')->name('manage_com.implementation')->middleware('IsAdmin');
    Route::post('/managecommunication/upload/implementation', 'Admin\ManageComSupport@createImplementation')->name('implementation.create')->middleware('IsAdmin');
    Route::get('/implementation/{step}', 'Admin\ManageComSupport@getAllImplementation')->name('implementation.get_type')->middleware('IsAdmin');
    Route::post('/implementation/status/{status}/{id}', 'Admin\ManageComSupport@setStatusImplementation')->name('implementation.set_status')->middleware('IsAdmin');
    Route::delete('/implementation/delete/{id}', 'Admin\ManageComSupport@deleteImplementation')->name('implementation.delete')->middleware('IsAdmin');
    Route::get('/form/implementation/upload/{slug}', 'Admin\ManageComSupport@getDataUpdateImplementation')->name('implementation.update')->middleware('IsAdmin');

    #DASHBOARD - MANAGEMENT CONSULTANT
        Route::get('/manageconsultant', 'Admin\ManageConsultantController@index')->name('manage_consultant')->middleware('IsAdmin');
        Route::post('/manageconsultant/create/proses', 'Admin\ManageConsultantController@create_proses')->name('manage_consultant.create_proses')->middleware('IsAdmin');
        Route::get('/manageconsultant/detail/{id}','Admin\ManageConsultantController@detail')->name('manage_consultant.detail')->middleware('IsAdmin');
        Route::post('/manageconsultant/edit/{id}', 'Admin\ManageConsultantController@edit')->name('manage_consultant.update')->middleware('IsAdmin');
        Route::get('/manageconsultant/{sort}/{sort2}/{search}','Admin\ManageConsultantController@index_content')->name('manage_consultant.index_content')->middleware('IsAdmin');
        Route::delete('/manageconsultant/delete/{id}','Admin\ManageConsultantController@destroy')->name('manage_consultant.destroy')->middleware('IsAdmin');
    #---

    #PROJECT
        Route::get('/myproject', 'MyProjectController@index')->name('myproject');
        Route::get('/project/{slug}', 'ProjectController@index')->name('project.index');
        Route::get('/searchproject', 'ProjectController@search')->name('project.search');
        Route::get('/getproject/{id}', 'ProjectController@getProject')->name('project.by_id');
        Route::get('/doc_proj/{kunci}/{search}/{sort}', 'ProjectController@doc_project')->name('project.document');
        Route::get('/myproject', 'MyProjectController@index')->name('myproject');
        Route::post('/archive', 'ProjectController@archive')->name('project.archive');
        Route::post('/archive/implementation', 'ProjectController@archiveimp')->name('implementation.archive');
        Route::get('/myproject/preview/{slug}', 'MyProjectController@preview')->name('myproject.preview');
        Route::get('/myproject/preview2/{slug}', 'MyProjectController@preview2')->name('myproject.preview2');
        Route::get('/project/view/{slug}', 'ViewProjectController@index')->name('project.view');
    #---

    #My Lesson Learned
        Route::get('/lessonlearned', 'MyLessonLearnedController@public')->name('lessonlearned');
        Route::get('/mylesson', 'MyLessonLearnedController@index')->name('mylesson');
        Route::get('/mylesson/{type}', 'MyLessonLearnedController@toMyLessonPath')->name('mylesson.type');

    #My Communication Support
        Route::get('/mycomsupport/initiative/{type}', 'CommunicationController@comInitTypePublic')->name('mycomsupport.initiative.type');
        Route::get('/mycomsupport/getall/initiative/{type}', 'CommunicationController@getAllComInitPublish')->name('mycomsupport.initiative.all');
        Route::get('/mycomsupport/initiative', 'CommunicationController@communicationInitiativePublic')->name('mycomsupport.initiative');
        Route::get('/mycomsupport/strategic', 'CommunicationController@strategicInit')->name('mycomsupport.strategic');
        Route::get('/mycomsupport/strategic/{slug}', 'CommunicationController@strategicByProjectPublic')->name('mycomsupport.strategic.type');
        Route::get('/mycomsupport/strategic/{slug}/{type}', 'CommunicationController@strategicByProjectType')->name('mycomsupport.strategic.type.content');
        Route::get('/mycomsupport/implementation', 'CommunicationController@implementationInit')->name('mycomsupport.implementation');
        Route::get('/mycomsupport/implementation/{type}', 'CommunicationController@setTypeImplementationInit')->name('mycomsupport.implementation.type');
        Route::get('/view/content', 'ContentComsupController@index')->name('view.comsup');
        Route::get('/view/implementation/{slug}', 'CommunicationController@getOneImplementation')->name('view.implement');
        Route::post('/communication/views/{table}/{id}', 'Admin\ManageComSupport@viewsContent')->name('com_support.views');
        Route::post('/communication/download/{table}/{id}', 'Admin\ManageComSupport@downloadFile')->name('com_support.download');
        Route::get('/myimplementation', 'Admin\ManageComSupport@getMyImplementation')->name('mycomsupport.myimplementation');
        Route::get('/myimplementation/preview/{id}', 'Admin\ManageComSupport@previewImplementation')->name('myimplementation.preview');

    #Comment
        Route::post('/komentar', 'CommentController@create')->name('comment.create');
        Route::post('/komentarforum', 'CommentController@createforum')->name('comment.createforum');
    #---
    #KONSULTAN
        Route::get('/consultant', 'ConsultantController@index')->name('consultant');
        Route::get('/consultant/{id}', 'ConsultantController@index')->name('consultant.index');
        Route::get('/proj_cons/{kunci}/{search}/{sort}', 'ConsultantController@proj_consultant')->name('consultant.project');
    #---

    #FAVORIT
        Route::get('/myfavorite', 'MyFavoriteController@index')->name('myfavorite');
        Route::get('/favoritproject/{id}', 'FavoriteProjectController@save')->name('favorit.project');
        Route::get('/favoritconsultant/{id}', 'FavoriteConsultantController@save')->name('favorit.consultant');
        Route::get('/favoritcomsupport/{table}/{id}', 'FavoriteComSupportController@save')->name('favorit.coms');
        Route::get('/fav_proj/{sort}', 'MyFavoriteController@fav_project')->name('favorite.project');
        Route::get('/fav_cons/{sort}', 'MyFavoriteController@fav_consultant')->name('favorite.consultant');
        Route::get('/fav_com/{sort}', 'MyFavoriteController@fav_com')->name('favorite.comsupport');
    #---

    #KATALOG
        Route::get('/katalog', 'KatalogController@index')->name('katalog.index');
        Route::post('/katalog', 'KatalogController@cari')->name('katalog.post');
        Route::get('/katalog/{key}', 'KatalogController@pencarian')->name('katalog.pencarian');
        // Route::post('/kat', 'KatalogController@filterisasi')->name('consultant.filterisasi');
    #---

    #KONTRIBUSI
        Route::get('/kontribusi', 'KontribusiController@index')->name('kontribusi');
        Route::get('/kontribusi/implementation', 'KontribusiController@formKontribusiImplementation')->name('kontribusi.implementation');
        #create form
        Route::get('/getconsultant', 'ConsultantController@getConsultant')->name('consultant.getdata');
        Route::get('/getuser', 'KontribusiController@getuser')->name('kontribusi.getuser');
        #create process
        Route::post('/kontribusi', 'KontribusiController@create')->name('kontribusi.create');
        Route::post('/kontribusi/implementation', 'KontribusiController@createImplementation')->name('kontribusi.createimplementation');
        #edit form
        Route::get('/kontribusi/{slug}', 'KontribusiController@edit')->name('kontribusi.edit');
        Route::get('/kontribusi/implementation/{slug}', 'KontribusiController@editImplementation')->name('kontribusiimpl.edit');
        Route::get('/kontribusi/doc/{slug}', 'KontribusiController@edit_doc')->name('kontribusi.edit_doc');
        #update process
        Route::post('/kontribusi/update', 'KontribusiController@update')->name('kontribusi.update');
        Route::post('/kontribusi/implementation/update', 'KontribusiController@updateImplementation')->name('kontribusiimpl.update');
        Route::get('/getdivisi/{direktorat}', 'KontribusiController@getDivisi')->name('kontribusi.divisi');
        Route::post('/myproject/appr/{id}', 'KontribusiController@appr')->name('kontribusi.appr');
        Route::post('/myproject/hapus/{id}', 'KontribusiController@hapus')->name('kontribusi.hapus');
        Route::post('/myproject/send/{id}', 'KontribusiController@send')->name('kontribusi.send');
        Route::post('/myproject/reject/{id}', 'KontribusiController@reject')->name('kontribusi.reject');
        Route::post('upimgcontent', 'KontribusiController@upimgcontent');
        Route::post('/up/{kategori}','KontribusiController@uploadphoto');
        Route::delete('/up/{kategori}','KontribusiController@delete');
        Route::post('/delete/{kategori}','KontribusiController@deleteNew');
        Route::post('/deleteonleave','KontribusiController@deleteOnLeave');
    #---

    #DIVISI
        Route::get('/divisi/{id}', 'DivisiController@index')->name('divisi');
        Route::get('/divisi/comsup/{from}/{id}', 'DivisiController@indexDivisiComsup')->name('divisi.comsup');
        Route::get('/proj_div/{kunci}/{search}', 'DivisiController@proj_divisi')->name('divisi.project');
        Route::get('/riwayat/{tahun}', 'DivisiController@riwayat')->name('riwayat');
        Route::get('/direktorat/comsup/{dir}/{from}', 'DirektoratController@indexDirComsup')->name('direktorat.comsup');
    #---

    #FORUM
        Route::get('/forum' ,'ForumController@index')->name('forum.index'); //halmaan
        Route::get('/forum/create' ,'ForumController@create')->name('forum.create'); //halaman --> CREATE
        Route::post('/forum/create' ,'ForumController@createproses')->name('forum.createproses'); //fungsi (BISA PUBLISH BISA SAVE - DEFAULT KOSONG)
        Route::get('/forum/draft/{id}' ,'ForumController@draft')->name('forum.draft'); //halaman --> DRAFT
        Route::get('/forum/edit/{id}' ,'ForumController@edit')->name('forum.edit'); //halaman --> DRAFT
        Route::post('/forum/update/{id}' ,'ForumController@update')->name('forum.update'); //fungsi (BISA PUBLISH BISA SAVE - DEFAULT NGELOAD)
        Route::delete('/forum/destroy/{id}' ,'ForumController@destroy')->name('forum.destroy'); //fungsi (BISA PUBLISH BISA SAVE - DEFAULT NGELOAD)
        Route::get('/forum/getDataList/{search}' ,'ForumController@getDataList')->name('forum.getDataList'); //fungsi (BISA PUBLISH BISA SAVE - DEFAULT NGELOAD)
        Route::get('/forum/{slug}' ,'ForumController@detail')->name('forum.detail'); //halaman
    #---

    #DOCUMENT
        Route::get('/list_doc/{project}/{id}', 'DocumentController@doc_list')->name('list.document');
        Route::get('/doc/download', 'DocumentController@downloadFile')->name('doc.download');
        Route::get('/attach/download/content/{id}', 'DocumentController@download_content')->name('com_support.download.content');
        Route::get('/attach/download/implementation/{id}', 'DocumentController@download_implementation')->name('implementation.download');
        Route::get('/attach/download/project/{id}', 'DocumentController@download_attach_project')->name('project.download');
        Route::get('/attach/download/strategic/{id}', 'DocumentController@download_attach_strategic')->name('strategic.download');
    #---------

    #notirfikasi
        Route::post('/notif' ,'NotifikasiController')->name('notif.readall');
    #---------

    # congratulation
    Route::post('/congrats','HomeController@congrats_update')->name('congrats');
    #--------

    #LOGOUT
        Route::get('/logout', 'Auth\AuthController@logout')->name('logout');
    #---

    #LAIN-LAIN
        Route::get('/about', 'HomeController@about')->name('about');
    #---
});

// yang belum login
Route::middleware('BeforeLoginMiddleware')->group(function(){
    Route::get('/c_s', 'Auth\ClearSession');
    Route::get('/refreshcaptcha', 'Auth\AuthController@refreshCaptcha');
    Route::get('/login', 'Auth\AuthController@index')->name('login');
    Route::post('/login', 'Auth\AuthController@login_proses')->name('login.proses'); //POST ke BE Login pake data Bristar yg sdh di save

// ADDINS
Route::post('/addins/login_addin' ,'AddinsController@login_addin')->name('addins.login_addin'); //halmaan
Route::post('/addins/cek_auth' ,'AddinsController@cek_auth')->name('addins.cek_auth'); //halmaan
});
Route::post('/addins/logout' ,'AddinsController@logout')->name('addins.logout'); //halmaan
Route::post('/addins/search/{key}' ,'AddinsController@cariall')->name('addins.cariall'); //halmaan
Route::post('/addins/searchproject' ,'AddinsController@searchproject')->name('addins.searchproject'); //halmaan
Route::post('/addins/detailproject/{id}' ,'AddinsController@detailproject')->name('addins.detailproject'); //halmaan
Route::post('/addins/detail/{id}' ,'AddinsController@detail')->name('addins.detail'); //halmaan

