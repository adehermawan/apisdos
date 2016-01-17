<?php

/**
 * Step 1: Require the Slim Framework using Composer's autoloader
 *
 * If you are not using Composer, you need to load Slim Framework with your own
 * PSR-4 autoloader.
 */
require 'vendor/autoload.php';
require 'connect.php';

/**
 * Step 2: Instantiate a Slim application
 *
 * This example instantiates a Slim application using
 * its default settings. However, you will usually configure
 * your Slim application now by passing an associative array
 * of setting names and values into the application constructor.
 */
$app = new Slim\App();

/**
 * Step 3: Define the Slim application routes
 *
 * Here we define several Slim application routes that respond
 * to appropriate HTTP request methods. In this example, the second
 * argument for `Slim::get`, `Slim::post`, `Slim::put`, `Slim::patch`, and `Slim::delete`
 * is an anonymous function.
 */

// get all adik
$app->get("/adik",function() use ($app,$db){
foreach ($db->tbl_adik as $value) {
  $adik["response"][]=array(
    'id' =>$value["id"],
    'name'=>$value["name"],
    'email'=>$value['email'],
    'school'=>$value['school'],
    'class'=>$value['class'],
    'photo'=>$value['photo'],
    'poin'=>$value['poin'],
    'level'=>$value['level']
   );
}
  echo json_encode($adik);
});

// get adik by id
$app->get('/adikById[/{id}]',function ($request, $response, $args) use ($app,$db){
  $adik=$db->tbl_adik()->where("id",$args['id']);
  $value=$adik->fetch();
  $adk["data"]=array(
    "id"=>$value["id"],
    "name"=>$value["name"],
    "email"=>$value["email"]
  );
  $hasil= json_encode(array(
    "status"=>200,
    "message"=>"data found",
    "response"=>$adk["data"]
  ));

  return $hasil;
});

// get all kakak
$app->get("/kaka",function() use ($app,$db){
  foreach ($db->tbl_kaka as $value) {
    $kaka["response"][]=array(
      'id'=>$value['id'],
      'name'=>$value['name'],
      'email'=>$value['email'],
      'university'=>$value['university'],
      'major'=>$value['major'],
      'poin'=>$value['poin']
    );
  }
  echo json_encode($kaka);
});

// get all topic
$app->get("/topic",function() use ($app,$db){
  foreach ($db->tbl_topic as $value) {
    $topic["response"][]=array(
      'id'=>$value['id'],
      'name'=>$value['name']
    );
  }
  echo json_encode($topic);
});

// get all questions
$app->get("/questions",function() use ($app,$db){
  foreach ($db->tbl_questions as $value) {
    $questions["response"][]=array(
      'id'=>$value['id'],
      'id_topic'=>$value['id_topic'],
      'question'=>$value['question']
    );
  }
  echo json_encode($questions);
});

// get question topic
$app->get("/questionsByTopic[/{id_topic}]",function($request,$response,$args) use ($app,$db){
  $questions=$db->tbl_questions()->where("id_topic",$args['id_topic']);
  if($value=$questions->fetch()){
    $ques["data"]=array(
      "id"=>$value["id"],
      "id_topic"=>$value["id_topic"],
      "question"=>$value["question"]
    );
    echo json_encode(array(
      "status"=>200,
      "message"=>"data found",
      "response"=>$ques["data"]
    ));
  }else {
    echo json_encode(array(
      "status"=>400,
      "message"=>"No Data"
    ));
  }
});
// get all reply adik
$app->get("/replyAdik",function() use ($app,$db){
  foreach ($db->tbl_reply_adik as $value) {
    $reply_adik["response"][]=array(
      'id'=>$value['id'],
      'id_adik'=>$value['id_adik'],
      'id_question'=>$value['id_question'],
      'reply'=>$value['reply'],
      'date'=>$value['date'],
      'status'=>$value['status']
    );
  }
  echo json_encode($reply_adik);
});

// get reply adik by question
$app->get("/replyAdikByQuestion[/{id_question}]",function($request,$response,$args) use ($app,$db){
  $reply=$db->tbl_reply_adik()->where("id_question",$args['id_question']);
  if($value=$reply->fetch()){
    $rep["data"]=array(
      'id'=>$value['id'],
      'id_adik'=>$value['id_adik'],
      'id_question'=>$value['id_question'],
      'reply'=>$value['reply'],
      'date'=>$value['date'],
      'status'=>$value['status']
    );
    echo json_encode(array(
      "status"=>200,
      "message"=>"data found",
      "response"=>$rep["data"]
    ));
  }else {
    echo json_encode(array(
      "status"=>400,
      "message"=>"No Data"
    ));
  }
});

// get all reply kaka
$app->get("/replyKaka",function() use ($app,$db){
  foreach ($db->tbl_reply_kaka as $value) {
    $reply_kaka["response"][]=array(
      'id'=>$value['id'],
      'id_kaka'=>$value['id_kaka'],
      'id_question'=>$value['id_question'],
      'reply'=>$value['reply'],
      'date'=>$value['date'],
      'status'=>$value['status']
    );
  }
  echo json_encode($reply_kaka);
});

// get reply kaka by question
$app->get("/replyKakaByQuestion[/{id_question}]",function($request,$response,$args) use ($app,$db){
  $reply=$db->tbl_reply_kaka()->where("id_question",$args['id_question']);
  if($value=$reply->fetch()){
    $rep["data"]=array(
      'id'=>$value['id'],
      'id_kaka'=>$value['id_kaka'],
      'id_question'=>$value['id_question'],
      'reply'=>$value['reply'],
      'date'=>$value['date'],
      'status'=>$value['status']
    );
    echo json_encode(array(
      "status"=>200,
      "message"=>"data found",
      "response"=>$rep["data"]
    ));
  }else {
    echo json_encode(array(
      "status"=>400,
      "message"=>"No Data"
    ));
  }
});

// insert adik
$app->post("/adik",function($request) use ($app,$db){
    $adik = $request->getParsedBody();
    $result=$db->tbl_adik()->insert($adik);
  if ($result) {
    echo json_encode(array(
      "status"=>200,
      "message"=>"success"
    ));
  }else {
    echo json_encode(array(
      "status"=>400,
      "message"=>"failed"
    ));
  }
});

// insert kaka
$app->post("/kaka",function($request) use ($app,$db){
    $kaka = $request->getParsedBody();
    $result=$db->tbl_kaka()->insert($kaka);
  if ($result) {
    echo json_encode(array(
      "status"=>200,
      "message"=>"success"
    ));
  }else {
    echo json_encode(array(
      "status"=>400,
      "message"=>"failed"
    ));
  }
});

// insert questions
$app->post("/questions",function($request) use ($app,$db){
    $questions = $request->getParsedBody();
    $result=$db->tbl_questions()->insert($questions);
  if ($result) {
    echo json_encode(array(
      "status"=>200,
      "message"=>"success"
    ));
  }else {
    echo json_encode(array(
      "status"=>400,
      "message"=>"failed"
    ));
  }
});

// insert reply adik
$app->post("/replyAdik",function($request) use ($app,$db){
    $replyAdik = $request->getParsedBody();
    $result=$db->tbl_reply_adik()->insert($replyAdik);
  if ($result) {
    echo json_encode(array(
      "status"=>200,
      "message"=>"success"
    ));
  }else {
    echo json_encode(array(
      "status"=>400,
      "message"=>"failed"
    ));
  }
});


// insert reply kaka
$app->post("/replyKaka",function($request) use ($app,$db){
    $replyKaka = $request->getParsedBody();
    $result=$db->tbl_reply_kaka()->insert($replyKaka);
  if ($result) {
    echo json_encode(array(
      "status"=>200,
      "message"=>"success"
    ));
  }else {
    echo json_encode(array(
      "status"=>400,
      "message"=>"failed"
    ));
  }
});

// insert topic
$app->post("/topic",function($request) use ($app,$db){
    $topic = $request->getParsedBody();
    $result=$db->tbl_topic()->insert($topic);
  if ($result) {
    echo json_encode(array(
      "status"=>200,
      "message"=>"success"
    ));
  }else {
    echo json_encode(array(
      "status"=>400,
      "message"=>"failed"
    ));
  }
});

// login adik
$app->post("/loginAdik",function($request) use ($app,$db){
    $log = $request->getParsedBody();
    $result=$db->tbl_adik()->where(array('email' => $log['email'],'password'=>$log['password']))->order('id')->limit(1);
  if (count($result)==1) {
    $value=$result->fetch();
    $adk["data"]=array(
      "id"=>$value["id"],
      "name"=>$value["name"],
      "email"=>$value["email"]
    );
    $hasil= json_encode(array(
      "status"=>200,
      "message"=>"data found",
      "response"=>$adk["data"]
    ));
       echo $hasil;
  }else {
    echo json_encode(array(
      "status"=>400,
      "message"=>"failed"
    ));
  }
});

// login kaka
$app->post("/loginKaka",function($request) use ($app,$db){
    $log = $request->getParsedBody();
    $result=$db->tbl_kaka()->where(array('email' => $log['email'],'password'=>$log['password']))->order('id')->limit(1);
  if (count($result)==1) {
    $value=$result->fetch();
    $kk["data"]=array(
      "id"=>$value["id"],
      "name"=>$value["name"],
      "email"=>$value["email"]
    );
    $hasil= json_encode(array(
      "status"=>200,
      "message"=>"data found",
      "response"=>$kk["data"]
    ));
       echo $hasil;
  }else {
    echo json_encode(array(
      "status"=>400,
      "message"=>"failed"
    ));
  }
});
/**
 * Step 4: Run the Slim application
 *
 * This method should be called last. This executes the Slim application
 * and returns the HTTP response to the HTTP client.
 */
$app->run();
