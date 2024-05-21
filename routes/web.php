<?php
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Grades\GradeController;
use App\Http\Controllers\Classrooms\ClassroomController;
use App\Http\Controllers\Sections\SectionController;
use App\Http\Controllers\Teachers\TeacherController;
use App\Http\Controllers\Students\StudentController;
use App\Http\Controllers\Students\PromotionController;
use App\Http\Controllers\Students\GraduatedController;
use App\Http\Controllers\Students\FeesInvoicesController;
use App\Http\Controllers\Students\FeesController;
use App\Http\Controllers\Students\ReceiptStudentsController;
use App\Http\Controllers\Students\ProcessingFeeController;
use App\Http\Controllers\Students\PaymentController;
use App\Http\Controllers\Students\AttendanceController;
use App\Http\Controllers\Subjects\SubjectController;
use App\Http\Controllers\Exams\ExamController;
use App\Http\Controllers\Quizzes\QuizzController;
use App\Http\Controllers\questions\QuestionController;
use App\Http\Controllers\Students\OnlineClasseController;
use App\Http\Controllers\Students\LibraryController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\Auth\LoginController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Auth::routes();

// Route::group(['middleware'=>['guest']], function(){

// 	Route::get('/', function()
// 		{
// 			return view('auth.login');
// 		});
// });

Route::get('/', [HomeController::class, 'index'])->name('selection');

Route::get('/login/{type}', [LoginController::class, 'loginForm'])->middleware('guest')->name('login.show');
// Route::get('/login/{type}', function($type){
	// return view('auth.login',compact('type'));
// })->name('login.show');

Route::post('/login', [LoginController::class, 'login'])->name('login');
Route::get('/logout/{type}', [LoginController::class, 'logout'])->name('logout');
	

//==============================Translate all pages============================
Route::group(
	[
		'prefix' => LaravelLocalization::setLocale(),
		'middleware' => [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath', 'auth']
	],
	function(){
	/** ADD ALL LOCALIZED ROUTES INSIDE THIS GROUP **/

    //==============================dashboard============================
	// default home page wich i modified it to dashboard
	Route::get('/dashboard', [HomeController::class, 'dashboard'])->name('dashboard');
	
	//==============================Grades============================
	Route::resource('/Grades', GradeController::class);
	Route::resource('/Classrooms', ClassroomController::class);
	Route::post('delete_all', [ClassroomController::class, 'delete_all'])->name('delete_all');
	Route::post('Filter_Classes', [ClassroomController::class, 'Filter_Classes'])->name('Filter_Classes');

	 //==============================Sections============================
	Route::resource('Sections', SectionController::class);
	Route::get('/classes/{id}', [SectionController::class, 'getclasses']);

	//  ==============================parents============================
	Route::view('add_parent', 'livewire.show_Form')->name('add_parent');
	
	// //==============================Teachers============================
	Route::resource('Teachers', TeacherController::class);

	//   //==============================Students============================
	Route::resource('Students', StudentController::class);
	// Route::get('/Get_classrooms/{id}', [StudentController::class, 'Get_classrooms']);
	// Route::get('/Get_Sections/{id}', [StudentController::class, 'Get_Sections']);
	Route::post('Upload_attachment', [StudentController::class, 'Upload_attachment'])->name('Upload_attachment');
    Route::get('Download_attachment/{studentsname}/{filename}', [StudentController::class, 'Download_attachment'])->name('Download_attachment');
    Route::post('Delete_attachment', [StudentController::class, 'Delete_attachment'])->name('Delete_attachment');
	  //==============================Promotion Students============================
    Route::resource('Promotion', PromotionController::class);
	//==============================Graduated Students============================
    Route::resource('Graduated', GraduatedController::class);

	Route::resource('Fees', FeesController::class);
    Route::resource('Fees_Invoices', FeesInvoicesController::class);
    // Route::get('/Get_fee/{id}', [FeesInvoicesController::class, 'Get_fee']);
    Route::resource('receipt_students', ReceiptStudentsController::class);
    Route::resource('ProcessingFee', ProcessingFeeController::class);
    Route::resource('Payment_students', PaymentController::class);
    Route::resource('Attendance', AttendanceController::class);
    Route::resource('subjects', SubjectController::class);
    Route::resource('Exams', ExamController::class);
    Route::resource('Quizzes', QuizzController::class);
    Route::resource('Questions', QuestionController::class);
    Route::resource('online_classes', OnlineClasseController::class);
    Route::get('indirect_admin', [OnlineClasseController::class, 'indirectCreate'])->name('indirect.create.admin');
    Route::post('indirect_admin', [OnlineClasseController::class, 'storeIndirect'])->name('indirect.store.admin');
	Route::resource('library', LibraryController::class);
    Route::get('download_file/{filename}', [LibraryController::class, 'downloadAttachment'])->name('downloadAttachment');
    Route::resource('settings', SettingController::class);
	
});

/** OTHER PAGES THAT SHOULD NOT BE LOCALIZED **/







