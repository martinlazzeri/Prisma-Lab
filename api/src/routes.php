<?php 

#Auth routes
$app->post('/token', Auth\Action\TokenAction::class);

//Login routes 
$app->get('/logout', 'LoginController:Logout');

//Users routes
$app->get('/users/token/{username}', 'UserController:GetByUsername');

$app->group('', function () use ($app) {

	//Audits routes
	$app->get('/audits', 'AuditController:GetByFilter');
	$app->get('/audits/{id}', 'AuditController:GetById');

	//Doctors routes
	$app->post('/doctors/userId/{userId}', 'DoctorController:Add');
	$app->put('/doctors/{id}/userId/{userId}', 'DoctorController:Edit');
	$app->get('/doctors/enrollment/{enrollment}/userId/{userId}', 'DoctorController:CheckEnrollment');
  $app->get('/doctors/userId/{userId}', 'DoctorController:GetByFilter');
	$app->get('/doctors/{id}/userId/{userId}', 'DoctorController:GetById');
	$app->delete('/doctors/{id}/userId/{userId}', 'DoctorController:Remove');
	$app->post('/doctors/search/userId/{userId}', 'DoctorController:Search');

	#Login routes 
	$app->post('/login/', 'LoginController:Login');

	//Patients routes
	$app->post('/patients/userId/{userId}', 'PatientController:Add');
	$app->put('/patients/{id}/userId/{userId}', 'PatientController:Edit');
	$app->get('/patients/dni/{dni}/userId/{userId}', 'PatientController:CheckDNI');
  $app->get('/patients/userId/{userId}', 'PatientController:GetByFilter');
	$app->get('/patients/{id}/userId/{userId}', 'PatientController:GetById');
	$app->delete('/patients/{id}/userId/{userId}', 'PatientController:Remove');
	$app->post('/patients/search/userId/{userId}', 'PatientController:Search');

	//Users routes
	$app->post('/users/userId/{userId}', 'UserController:Add');
	$app->get('/users/username/{username}/userId/{userId}', 'UserController:CheckUsername');
	$app->get('/users/email/{email}/userId/{userId}', 'UserController:CheckEmail');
	$app->put('/users/{id}/userId/{userId}', 'UserController:Edit');
  $app->get('/users/userId/{userId}', 'UserController:GetByFilter');
	$app->get('/users/{id}/userId/{userId}', 'UserController:GetById');
	$app->delete('/users/{id}/userId/{userId}', 'UserController:Remove');
	$app->post('/users/search/userId/{userId}', 'UserController:Search');

	//Welfares routes
	$app->post('/welfares/userId/{userId}', 'WelfareController:Add');
	$app->get('/welfares/code/{code}/userId/{userId}', 'WelfareController:CheckCode');
	$app->get('/welfares/name/{name}/userId/{userId}', 'WelfareController:CheckName');
	$app->put('/welfares/{id}/userId/{userId}', 'WelfareController:Edit');
  $app->get('/welfares/userId/{userId}', 'WelfareController:GetByFilter');
	$app->get('/welfares/{id}/userId/{userId}', 'WelfareController:GetById');
	$app->delete('/welfares/{id}/userId/{userId}', 'WelfareController:Remove');
	$app->post('/welfares/search/userId/{userId}', 'WelfareController:Search');

	#Authorise - Third-party apps
	$app->post('/authorise', Auth\Action\AuthoriseAction::class);

})->add(Auth\GuardMiddleware::class);