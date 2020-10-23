<?php 
    //Include Configuration File
    include('config.php');

    $login_button = '';

    //This $_GET["code"] variable value received after user has login into their Google Account redirct to PHP script then this variable value has been received
    if(isset($_GET["code"]))
    {
        //It will Attempt to exchange a code for an valid authentication token.
        $token = $google_client->fetchAccessTokenWithAuthCode($_GET["code"]);

        //This condition will check there is any error occur during geting authentication token. If there is no any error occur then it will execute if block of code/
        if(!isset($token['error']))
        {
            //Set the access token used for requests
            $google_client->setAccessToken($token['access_token']);

            //Store "access_token" value in $_SESSION variable for future use.
            $_SESSION['access_token'] = $token['access_token'];

            //Create Object of Google Service OAuth 2 class
            $google_service = new Google_Service_Oauth2($google_client);

            //Get user profile data from google
            $data = $google_service->userinfo->get();

            //Below you can find Get profile data and store into $_SESSION variable
            if(!empty($data['given_name']))
            {
                $_SESSION['user_first_name'] = $data['given_name'];
            }

            if(!empty($data['family_name']))
            {
                $_SESSION['user_last_name'] = $data['family_name'];
            }

            if(!empty($data['email']))
            {
                $_SESSION['user_email_address'] = $data['email'];
            }

            if(!empty($data['gender']))
            {
                $_SESSION['user_gender'] = $data['gender'];
            }

            if(!empty($data['picture']))
            {
                $_SESSION['user_image'] = $data['picture'];
            }
        }
    }

    //This is for check user has login into system by using Google account, if User not login into system then it will execute if block of code and make code for display Login link for Login using Google account.
    if(!isset($_SESSION['access_token']))
    {
        //Create a URL to obtain user authorization
        $login_button = '<a style="font-size:16px;" class="badge badge-danger" href="'.$google_client->createAuthUrl().'">Sign in with google account</a>';
    }

?>
<!DOCTYPE html>
<html lang="en">

    <!-- Basic -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    
    <!-- Mobile Metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    
    <!-- Site Metas -->
    <title>Newspaper, Explore the world</title>
    <meta name="keywords" content="">
    <meta name="description" content="">
    <meta name="author" content="">
    
    <!-- Site Icons -->
    <link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon" />
    <link rel="apple-touch-icon" href="images/apple-touch-icon.png">
    
    <!-- Design fonts -->
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" rel="stylesheet"> 

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.css" rel="stylesheet">

    <!-- FontAwesome Icons core CSS -->
    <link href="css/font-awesome.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="style.css" rel="stylesheet">

    <!-- Responsive styles for this template -->
    <link href="css/responsive.css" rel="stylesheet">

    <!-- Colors for this template -->
    <link href="css/colors.css" rel="stylesheet">

    <!-- Version Tech CSS for this template -->
    <link href="css/version/tech.css" rel="stylesheet">

    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>
<body>

    <div id="wrapper">
       <br> <br>

        <section>
            <div class="container">
                <div class="row">
                    <div class="col-md-9 mx-0">
                        <h1>eNewspaper</h1>
                        
                    </div>
                    <div class="col-md-3 mr-15">
                        
                        <?php
                           if($login_button == '')
                           {
                            echo "Welcome <br>";
                            echo $_SESSION['user_first_name'].' '.$_SESSION['user_last_name'];
                            
                            echo '<p><a href="logout.php">Logout</p>';
                           }
                           else
                           {
                            echo '<div align="center">'.$login_button . '</div>';
                           }
                        ?>
                    </div>
                </div>
                <hr>
            </div>
        </section>


        <section class="section">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="page-wrapper">
                            <!-- end blog-top -->
                            <?php
                              if(file_exists('news.json')){
                                $api_url = 'news.json';
                                $newslist = json_decode(file_get_contents($api_url));
                              }else{
                                 //we will be fetching only sports related news
                                $api_url = 'https://content.guardianapis.com/search?api-key=3a1be088-1ff4-43c4-a928-a88dac391668';
                                $newslist = file_get_contents($api_url);
                                file_put_contents('news.json', $newslist);
                                $newslist = json_decode($newslist);
                              }
                              foreach($newslist->response->results as $news){?>
                            <div class="blog-list clearfix">
                                <div class="blog-box row ">
                                    

                                    <div class="col-md-12 jumbotron">
                                        <h4><a href="<?php echo $news->webUrl ?>" target="_blank" title=""><?php echo $news->webTitle; ?></a></h4>
                                        <small class="firstsmall"><a href="<?php echo $news->webUrl ?>" target="_blank" title=""><?php echo $news->sectionName; ?></a></small> ||
                                        <small><a href="<?php echo $news->webUrl ?>" target="_blank" title=""><?php echo $news->webPublicationDate; ?></a></small>
                                    </div><!-- end meta -->
                                </div><!-- end blog-box -->
                                <hr class="invis">
                            </div>
                            <?php } ?>

                        
                    </div><!-- end col -->
                </div><!-- end row -->
            </div><!-- end container -->
        </section>

        <footer class="footer">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 text-center">
                        <div class="widget">
                            <div class="footer-text">
                                <p>Tech Blog is a technology blog, we sharing marketing, news and gadget articles.</p>
                                <div class="social">
                                    <a href="#" data-toggle="tooltip" data-placement="bottom" title="Facebook"><i class="fa fa-facebook"></i></a>              
                                    <a href="#" data-toggle="tooltip" data-placement="bottom" title="Twitter"><i class="fa fa-twitter"></i></a>
                                    <a href="#" data-toggle="tooltip" data-placement="bottom" title="Instagram"><i class="fa fa-instagram"></i></a>
                                    <a href="#" data-toggle="tooltip" data-placement="bottom" title="Google Plus"><i class="fa fa-google-plus"></i></a>
                                    <a href="#" data-toggle="tooltip" data-placement="bottom" title="Pinterest"><i class="fa fa-pinterest"></i></a>
                                </div>

                                <hr class="invis">
                            </div><!-- end footer-text -->
                        </div><!-- end widget -->
                    </div><!-- end col -->  
                </div>

                <div class="row text-center">
                    <div class="col-md-12 text-center">
                        <br>
                        <div class="copyright">&copy; eNewspaper</div>
                    </div>
                </div>
            </div><!-- end container -->
        </footer><!-- end footer -->

        <div class="dmtop">Scroll to Top</div>
        
    </div><!-- end wrapper -->

    <!-- Core JavaScript
    ================================================== -->
    <script src="js/jquery.min.js"></script>
    <script src="js/tether.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/custom.js"></script>

</body>
</html>