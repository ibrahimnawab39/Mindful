<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" theme='lightTheme'>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Blocked | Get Started</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('assets/favicon/apple-touch-icon.png')}} ">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('assets/favicon/favicon-32x32.png')}} ">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/favicon/favicon-16x16.png')}} ">
    <link rel="manifest" href="{{ asset('assets/favicon/site.webmanifest')}} ">
    <link rel="mask-icon" href="{{ asset('assets/favicon/safari-pinned-tab.svg')}} " color="#5bbad5">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="theme-color" content="#f1f1f1">
    <link
        href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;0,800;1,200;1,300;1,400;1,500;1,600;1,700;1,800&display=swap"
        rel="stylesheet">
         <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css">
    <!-- Add the slick-theme.css if you want default styling -->
    <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css" />
    <!-- Add the slick-theme.css if you want default styling -->
    <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css" />
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/responsive.css') }}">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
</head>
<body>
    <div class="main-wrapper" style="max-width:100%">
   <style>
  
    p {
      margin-bottom: 10px;
    }
    ul {
      list-style-type: disc;
      margin-left: 20px;
    }
    .highlight {
      color: red;
      font-weight: bold;
    }
  </style> 
    <section class="container">
        <div class="block-card">
         <h1 class="highlight">Blocked User ! </h1>
         <p>You have been blocked due to a violation of our rules. <span id="seemore">For more information</span>.</p>
        </div>
        <div class="rules" style="display:none">
           <h1>Mindful Rule's</h1>
         <p>In order to ensure the safety of all users, it is mandatory for individuals to be at least 13 years old before participating on this site, as there are potential risks involved in interacting    with unknown individuals online.</p>
         <p>No inappropriate or offensive behavior: Users should refrain from using any language or behavior that is vulgar, obscene, or offensive.</p>
         <p>No spamming or advertising: Users should not spam the site or advertise any products or services.</p>
         <p>No sharing of personal information: Users should not share any personal information such as private phone numbers and email addresses, this protects everyone's rights to privacy.</p>
         <p>No impersonation: Users should not pretend to be someone else or misrepresent themselves.</p>
         <p>No harassment or bullying: Users should not harass or bully other users, including using hate speech or making threats.</p>
         <p>No illegal activities: Users should not engage in any illegal activities, such as sharing pirated content or engaging in hacking.</p>
         <p>No nudity or sexual content: Users should not share any nudity or sexually explicit content.</p>
         <p>No racist or discriminatory behavior: Users should not engage in any racist or discriminatory behavior towards other users.</p>
         <p>No hacking or exploiting: Users should not attempt to hack or exploit the website or other users.</p>
         <p>We highly encourage reporting any behavior that violates the aforementioned rules.</p>
        
         <h2>Report Violations</h2>
         <p>If you have witnessed any behavior that violates the rules stated above, please report it to our team immediately. We take these matters seriously and will take appropriate action.</p>
         <ul>
           <li>Email: report@mindful.com</li>
           <li>Phone: +1-123-456-7890</li> 
        </ul>
         </div>
    </section>
  </div>
    <script src="https://code.jquery.com/jquery-3.6.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <script src="{{ asset('assets/js/main.js') }}"></script>
    
    
    <script>
        $(document).on('click','#seemore',function(){
            $('.rules').fadeToggle();
        })
    </script>
</body>
</html>

