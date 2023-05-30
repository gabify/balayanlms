<!DOCTYPE html>
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href= "../balayanlms/node_modules/bootstrap/dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="../balayanlms/node_modules/bootstrap-icons/font/bootstrap-icons.min.css">
        <link rel="stylesheet" href="../balayanlms/template/style.css">
        <title>Library Management System</title>
    </head>
    <body>
        <nav class="navbar">
            <div class="container-fluid ps-4 py-2">
                <a class="navbar-brand fs-4 fw-bold text-light" href="../balayanlms/index.php">
                    <i class="bi-journal-text"></i>
                    Library Management System
                </a>
                <button 
                    class="btn" 
                    type="button" 
                    data-bs-toggle="offcanvas" 
                    data-bs-target="#offcanvasnav" 
                    aria-controls="offcanvasExample">
                        <i class="bi-list fs-3 fw-bold text-light"></i>
                </button>
            </div>
        </nav>

        <div class="offcanvas offcanvas-start side-nav" tabindex="-1" id="offcanvasnav" aria-labelledby="SideNavigation">
            <div class="offcanvas-header">
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body">
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link fs-5 fw-light text-light" aria-current="page" href="../balayanlms/index.php">
                            <i class="bi-speedometer2"></i>
                            Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link fs-5 fw-light text-light" href="../balayanlms/bookDashboard.php">
                            <i class="bi-journal-bookmark-fill"></i>
                            Books
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link fs-5 fw-light text-light" href="#">
                            <i class="bi-journal-bookmark"></i>
                            Theses
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link fs-5 fw-light text-light" href="#">
                            <i class="bi-person-circle"></i>
                            Students
                        </a>
                    </li>
                </ul>
            </div>
        </div>