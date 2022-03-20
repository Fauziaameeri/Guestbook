<?php
//start the session
session_start();

//Initialize variables
$validLogin = false;

//If the user is already logged in
if (isset($_SESSION['username'])) {
  //Set $validLogin to true
  $validLogin = true;
}

$servername = "localhost";
$username = "fameeri1_php";
$password = "Application@12";
$database = "fameeri1_grc";
$port = 3306;

function validateLink($link)
{
  return filter_var($link, FILTER_VALIDATE_URL);
}

function validateEmail($email)
{
  return filter_var($email, FILTER_VALIDATE_EMAIL);
}

function validateForm()
{
  // validating first name
  if (!isset($_POST["fname"])) {
    return "First name";
  }

  // validating last name
  if (!$_POST["lname"]) {
    return "Last name";
  }

  // validate linkedin url
  if (!isset($_POST["linkedin"])) {
    return "Valid linkedin url";
  } else {
    if (!validateLink($_POST["linkedin"])) {
      return "Valid linkedin url";
    }
  }

  // validating email
  if (isset($_POST["mailing-list"])) {
    if ($_POST["mailing-list"] == 'on' && !isset($_POST["email"])) {
      return "Valid email";
    }
  }

  if (isset($_POST["email"])) {
    if (!validateEmail($_POST["email"])) {
      return "Valid email";
    }
  }

  if (!isset($_POST["mtype"])) {
    return "How you met";
    if ($_POST["mtype"] === "other" && !isset($_POST["other"])) {
      return "How you met";
    }
  }

  return false;
};

function renderMailingListYesNo()
{
  return (isset($_POST['mailing-list']) && $_POST['mailing-list'] == 'on') ? 'YES' : 'NO';
};

$isDataInvalid = validateForm();

if ($isDataInvalid) {
  $failureHtml = "
<!DOCTYPE html>
<html lang='en'>

<head>
  <meta charset='UTF-8' />
  <meta http-equiv='X-UA-Compatible' content='IE=edge' />
  <meta name='viewport' content='width=device-width, initial-scale=1.0' />
  <!-- Favicon -->
  <link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Montserrat' />
  <link rel='icon' type='image/x-icon' href='favicon.ico' />
  <!-- Bootstrap CSS -->
  <link rel='stylesheet' href='https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css' integrity='sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T' crossorigin='anonymous' />
  <link rel='stylesheet' href='styles.css' />
  <!-- validation script -->
  <script src='main.js'></script>
  <!-- Title -->
  <title>Guestbook</title>
  <style>
    body,
    h1,
    h2,
    h3,
    h4,
    h5,
    h6 {
      font-family: 'Montserrat', sans-serif;
    }

    .wide {
      letter-spacing: 4px;
      margin-top: 1rem;
    }
  </style>
</head>

<body>
  <!-- Header -->
  <header class='d-flex flex-column align-items-center justify-content-center' style='padding: 128px 16px' id='home'>
    <h1 class='display-2'><b>Fauzia Ameeri</b></h1>
    <h3>Web Developer</h3>
    <nav class='nav' id='navbar'>
      <a class='nav-item nav-link' id='resume' href='../Resume/resume.php'>Resume</a>
      <a class='nav-item nav-link' id='guestbook' href='../guestbook/index.php'>Guestbook</a>
      <a class='nav-item nav-link' id='adminPage' href='../Adminpage/index.php'>Admin Page</a>"
    . ($validLogin ? "<a class='nav-item nav-link' id='logout' href='../Adminpage/logout.php'>Logout</a>" : "")
    . "</nav>
    <h2 class='text-secondary'>Guestbook Submission Error</h2>
    <hr class='w-100' />
  </header>

  <div class='container border rounded p-3 mb-4'>" . $isDataInvalid . " is not provided.</div>
  <!-- Optional JavaScript -->
  <!-- jQuery first, then Popper.js, then Bootstrap JS -->
  <script src='https://code.jquery.com/jquery-3.3.1.slim.min.js' integrity='sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo' crossorigin='anonymous'>
  </script>
  <script src='https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js' integrity='sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1' crossorigin='anonymous'>
  </script>
  <script src='https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js' integrity='sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM' crossorigin='anonymous'>
  </script>
</body>

</html>";
  print $failureHtml;
} else {

  function paramValue($param)
  {
    if (is_null($param) || empty($param)) {
      return "NULL";
    }
    return "'$param'";
  }

  $query = "INSERT INTO `guestbook` (`first`, `last`, `job`, `company`, `linkedin`, `email`, `meeting_type`, `other_meeting_type`, `message`, `mailing_list_subscription`, `mailing_type`) VALUES ('" . $_POST['fname'] . "', '" . $_POST['lname'] . "', " . paramValue($_POST['job']) . ", " . paramValue($_POST['company']) . ", " . paramValue($_POST['linkedin']) . ", " . paramValue($_POST['email']) . ", " . paramValue($_POST['mtype']) . ", " . paramValue($_POST['other']) . ", " . paramValue($_POST['message']) . ", " . ($_POST['mailing-list'] == 'on' ? "'on'" : "'off'") . ", " . paramValue($_POST['email-format']) . ")";

  $conn = mysqli_connect($servername, $username, $password, $database, $port);

  $successHtml = "
<!DOCTYPE html>
<html lang='en'>

<head>
  <meta charset='UTF-8' />
  <meta http-equiv='X-UA-Compatible' content='IE=edge' />
  <meta name='viewport' content='width=device-width, initial-scale=1.0' />
  <!-- Favicon -->
  <link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Montserrat' />
  <link rel='icon' type='image/x-icon' href='favicon.ico' />
  <!-- Bootstrap CSS -->
  <link rel='stylesheet' href='https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css' integrity='sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T' crossorigin='anonymous' />
  <link rel='stylesheet' href='styles.css' />
  <!-- validation script -->
  <script src='main.js'></script>
  <!-- Title -->
  <title>Guestbook</title>
  <style>
    body,
    h1,
    h2,
    h3,
    h4,
    h5,
    h6 {
      font-family: 'Montserrat', sans-serif;
    }

    .wide {
      letter-spacing: 4px;
      margin-top: 1rem;
    }
  </style>
</head>

<body>
  <!-- Header -->
  <header class='d-flex flex-column align-items-center justify-content-center' style='padding: 128px 16px' id='home'>
    <h1 class='display-2'><b>Fauzia Ameeri</b></h1>
    <h3>Web Developer</h3>
    <nav class='nav' id='navbar'>
      <a class='nav-item nav-link' id='resume' href='../Resume/resume.php'>Resume</a>
      <a class='nav-item nav-link' id='guestbook' href='../guestbook/index.php'>Guestbook</a>
      <a class='nav-item nav-link' id='adminPage' href='../Adminpage/index.php'>Admin Page</a>"
    . ($validLogin ? "<a class='nav-item nav-link' id='logout' href='../Adminpage/logout.php'>Logout</a>" : "")
    . "</nav>
    <h2 class='text-secondary'>Guestbook Submission Success</h2>
    <hr class='w-100' />
  </header>

  <div class='container border rounded p-3 mb-4'>
    <form action='submit.php' method='post'>
      <!-- Contact Info -->
      <legend class='d-md-inline pt-2'>Contact Info:</legend>
      <div class='row'>
        <div class='form-group col-md-6'>
          <label for='fname'>First Name</label>
          <div id='fname'>" . $_POST['fname'] . "</div>
          <span class='err' id='err-fname'></span>
        </div>
        <div class='form-group col-md-6'>
          <label for='lname'>Last Name</label>
          <div id='lname'>" . $_POST['lname'] . "</div>
          <span class='err' id='err-lname'></span>
        </div>
      </div>
      <div class='row'>
        <div class='form-group col-md-6'>
          <label for='job'>Job Title</label>
          <div id='job'>" . $_POST['job'] . "</div>
        </div>
        <div class='form-group col-md-6'>
          <label for='company'>Company</label>
          <div id='company'>" . $_POST['company'] . "</div>
        </div>
      </div>
      <div class='row'>
        <div class='form-group col-md-6'>
          <label for='linkedin'>LinkedIn URL</label>
          <div id='linkedin'>" . $_POST['linkedin'] . "</div>
          <span class='err' id='err-linkedin'></span>
        </div>
        <div class='form-group col-md-6'>
          <label for='email'>Email Address</label>
          <div id='email'>" . $_POST['email'] . "</div>
          <span class='err' id='err-email'></span>
        </div>
      </div>
      <!-- How we met -->
      <legend class='d-md-inline pt-2'>How we met</legend>
      <div class='row'>
        <div class='form-group col-md-6'>
          <label for='mtype'>How did we meet?</label>
          <div id='mtype'>" . $_POST['mtype'] . "</div>
          <span class='err' id='err-mtype'></span>
        </div>
        <div class='form-group col-md-6' id='other-type'>
          <label for='other'>Other (please specify)</label>
          <div id='other'>" . $_POST['other'] . "</div>
          <span class='err' id='err-other'></span>
        </div>
        <div class='form-group col-md-6'>
          <label for='message'>Message</label>
          <div id='message'>" . $_POST['message'] . "</div>
        </div>
      </div>
      <!-- Mailing List -->
      <div class='form-check my-2'>
        <label class='form-check-label' for='mailing-list'>Added to mailing list</label>
        <div id='mailing-list'>" . renderMailingListYesNo() . "</div>
      </div>
      <div id='mailing-list-type' class='hide'>
        <label>Chosen mail format:</label>
        <div id='email-format'>" . $_POST['email-format'] . "</div>
      </div>
    </form>
  </div>
  <!-- Optional JavaScript -->
  <!-- jQuery first, then Popper.js, then Bootstrap JS -->
  <script src='https://code.jquery.com/jquery-3.3.1.slim.min.js' integrity='sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo' crossorigin='anonymous'>
  </script>
  <script src='https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js' integrity='sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1' crossorigin='anonymous'>
  </script>
  <script src='https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js' integrity='sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM' crossorigin='anonymous'>
  </script>
</body>

</html>";

  // Connection Check
  if (!$conn) {
    die("Connection failed: ");
  } else {
    // query execution
    if ($conn->query($query) === TRUE) {
      print $successHtml;
      $conn->close();
    } else {
      echo mysqli_error($conn);
      $conn->close();
    }
  }
}
