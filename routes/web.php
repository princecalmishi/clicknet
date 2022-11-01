<?php

use Illuminate\Support\Facades\Route;
use App\Models\Cart;


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

// Route::get('/', function () {
//     return view('welcome');
// });




Route::get('/recheck', [App\Http\Controllers\HomeController::class, 'recheck'])->name('recheck');


Auth::routes(['verify' => true]);
// Route::get('/', [App\Http\Controllers\HomeController::class, 'welcome'])->name('welcome')->middleware->('verified);
Route::get('/', [App\Http\Controllers\HomeController::class, 'welcome'])->name('welcome');


// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');contactform

// protect all routes with must verify email
Route::group(['middleware' => ['verified']], function(){

                Route::get('/helppage', [App\Http\Controllers\HomeController::class, 'helppage'])->name('helppage');
                Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
                Route::post('/submitwork', [App\Http\Controllers\HomeController::class, 'submitwork'])->name('submitwork');
                Route::post('/submitworkreturn', [App\Http\Controllers\HomeController::class, 'submitworkreturn'])->name('submitworkreturn');
                Route::post('/submitworkreturnagain', [App\Http\Controllers\HomeController::class, 'submitworkreturnagain'])->name('submitworkreturnagain');
                Route::get('/markmessage/{id}', [App\Http\Controllers\HomeController::class, 'markmessage'])->name('markmessage');
                Route::get('/updatesite', [App\Http\Controllers\HomeController::class, 'updatesite'])->name('updatesite');
                Route::post('/updatesiteform', [App\Http\Controllers\HomeController::class, 'updatesiteform'])->name('updatesiteform');

                Route::get('/view/{id}', [App\Http\Controllers\HomeController::class, 'view'])->name('view');
                Route::get('/checkifclicked/{id}', [App\Http\Controllers\HomeController::class, 'checkifclicked'])->name('checkifclicked');
               
                Route::get('/viewmywork/{id}', [App\Http\Controllers\HomeController::class, 'viewmywork'])->name('viewmywork');
                Route::get('/approve/{id}', [App\Http\Controllers\HomeController::class, 'userapprove'])->name('approve');
                Route::get('/approvework/{id}', [App\Http\Controllers\HomeController::class, 'userapprove'])->name('approvework');
                Route::get('/addmysite', [App\Http\Controllers\HomeController::class, 'addmysite'])->name('addmysite');
                Route::post('/submitmysite', [App\Http\Controllers\HomeController::class, 'submitmysite'])->name('submitmysite');
                Route::get('/rules', [App\Http\Controllers\HomeController::class, 'rules'])->name('rules');
                Route::get('/mywork', [App\Http\Controllers\HomeController::class, 'mywork'])->name('mine');
                Route::get('/completework', [App\Http\Controllers\HomeController::class, 'completework'])->name('completework');
                Route::get('/pendingwork', [App\Http\Controllers\HomeController::class, 'pendingwork'])->name('pendingwork');
                Route::get('/reports', [App\Http\Controllers\HomeController::class, 'reports'])->name('reports');
                Route::get('/reportuser/{id}', [App\Http\Controllers\HomeController::class, 'reportuser'])->name('reportuser');
                Route::post('/reportuserform', [App\Http\Controllers\HomeController::class, 'reportuserform'])->name('reportuserform');
                Route::get('/userfeedback', [App\Http\Controllers\HomeController::class, 'feedbacks'])->name('userfeedback');
                Route::get('/myreply', [App\Http\Controllers\HomeController::class, 'myreply'])->name('myreply');
                Route::post('/userfeedbackpost', [App\Http\Controllers\HomeController::class, 'userfeedbackpost'])->name('userfeedbackpost');
           

      
                Route::get('/contact', [App\Http\Controllers\HomeController::class, 'contact'])->name('contact');
                Route::post('/contactuspost', [App\Http\Controllers\HomeController::class, 'contactuspost'])->name('contactuspost');
                Route::post('/newsletter', [App\Http\Controllers\HomeController::class, 'newsletter'])->name('newsletter');
                Route::post('/contactform', [App\Http\Controllers\HomeController::class, 'contactform'])->name('contactform');
                Route::get('/approval', [App\Http\Controllers\HomeController::class, 'clickadmin'])->name('approval');
                Route::get('/application', [App\Http\Controllers\HomeController::class, 'application'])->name('application');
                Route::post('/submitapp', [App\Http\Controllers\HomeController::class, 'submitapp'])->name('submitapp');
                Route::get('/waiting', [App\Http\Controllers\HomeController::class, 'waiting'])->name('waiting');               


                




               
            });

            Route::group(['middleware' => ['admin']], function(){

                // admin
                // Route::resource('admin', 'App\Http\Controllers\AdminController')->name('admin');

                Route::get('/admin', [App\Http\Controllers\AdminController::class, 'index'])->name('admin');
                Route::get('/replyuser/{id}/{userid}', [App\Http\Controllers\AdminController::class, 'replyuser'])->name('replyuser');
                Route::post('/replyuserform', [App\Http\Controllers\AdminController::class, 'replyuserform'])->name('replyuserform');
                
                Route::get('/readfeedback/{id}', [App\Http\Controllers\AdminController::class, 'readfeedback'])->name('readfeedback');
                Route::get('/readusermessages/{id}', [App\Http\Controllers\AdminController::class, 'readusermessages'])->name('readusermessages');

                Route::get('/allusers', [App\Http\Controllers\AdminController::class, 'allusers'])->name('allusers');

                Route::get('/inactiveusers', [App\Http\Controllers\AdminController::class, 'inactiveusers'])->name('inactiveusers');
                Route::get('/activeusers', [App\Http\Controllers\AdminController::class, 'activeusers'])->name('activeusers');
                Route::get('/reportedusers', [App\Http\Controllers\AdminController::class, 'reportedusers'])->name('reportedusers');
                Route::get('/adminsite', [App\Http\Controllers\AdminController::class, 'adminsite'])->name('adminsite');
                Route::get('/sendmail', [App\Http\Controllers\AdminController::class, 'sendmail'])->name('sendmail');
                Route::post('/sendmailform', [App\Http\Controllers\AdminController::class, 'sendmailform'])->name('sendmailform');
                Route::get('/approvalrequests', [App\Http\Controllers\AdminController::class, 'approvalrequests'])->name('approvalrequests');
                Route::get('/feedbacks', [App\Http\Controllers\AdminController::class, 'feedbacks'])->name('feedbacks');
                Route::get('/usermessages', [App\Http\Controllers\AdminController::class, 'usermessages'])->name('usermessages');
               

                Route::get('/approve/{id}/{userid}', [App\Http\Controllers\AdminController::class, 'approveuser'])->name('approveuser');
                Route::get('/denyapproveuser/{id}/{userid}', [App\Http\Controllers\AdminController::class, 'denyapproveuser'])->name('denyapproveuser');
                Route::get('/ban/{id}/{reportedid}', [App\Http\Controllers\AdminController::class, 'banreportedusers'])->name('banreportedusers');
                Route::get('/suspend/{id}/{reportedid}', [App\Http\Controllers\AdminController::class, 'suspendreportedusers'])->name('suspendreportedusers');
                Route::get('/ignore/{id}/{reportedid}', [App\Http\Controllers\AdminController::class, 'ignorereportedusers'])->name('ignorereportedusers');
            });
          
            // end of protected routes


                Route::get('/logout', '\App\Http\Controllers\Auth\LoginController@logout');

                Route::get('sendbasicemail','\App\Http\Controllers\MailController@basic_email');
                Route::get('sendhtmlemail','\App\Http\Controllers\MailController@html_email');
                Route::get('sendattachmentemail','\App\Http\Controllers\MailController@attachment_email');