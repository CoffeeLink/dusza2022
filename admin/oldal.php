<!DOCTYPE html>
<html lang="hu">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <!-- Bootstrap behívása -->
    <link rel="stylesheet" href="/css/bootstrap/css/bootstrap.min.css" />
    <script src="/css/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Font Awesome behívása -->
    <script src="https://kit.fontawesome.com/df92ea1e57.js" crossorigin="anonymous"></script>

    <!-- Saját CSS behívása -->
    <link rel="stylesheet" href="/css/page.css" />
    <title>Blogmotor</title>
</head>

<body>
    <!-- Weboldalt körbefoglaló div -->
    <div class="container">
        <!-- Navigációs sor behívása -->
        <header class="d-flex flex-wrap justify-content-center py-3 mb-4 border-bottom">
            <!-- Weboldal főcímének megjelenítése -->
            <a href="/" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-dark text-decoration-none">
                <span class="fs-4">Weboldal címe</span>
            </a>

            <!-- Navigációs sor hivatkozásai -->
            <ul class="nav nav-pills">
                <li class="nav-item">
                    <a href="#" class="nav-link">Főoldal</a>
                </li>
                <li class="nav-item"><a href="#" class="nav-link">Oldal1</a></li>
                <li class="nav-item"><a href="#" class="nav-link">Oldal2</a></li>
                <li class="nav-item">
                    <a href="#" class="nav-link">Bejelentkezés</a>
                </li>
                <li class="nav-item search-item">
                    <input type="search" class="form-control" placeholder="Keresés" aria-label="Search" />
                </li>

                <!-- Keresés -->
                <li class="nav-item">
                    <button type="submit" class="btn-primary btn kereses">
                        <i class="fa fa-search"></i>
                    </button>
                </li>
            </ul>
        </header>

        <!-- Tartalom -->
        <h1>Oldal címe</h1>
        <div class="row">
            <div class="col-lg-4 col-md-6 col-sm-12">
                <div class="card">
                    <!-- Indexkép -->
                    <img class="img-fluid" src="/img/default_image.png" alt="Indexkép" />

                    <!-- Bejegyzés megjelenő adatai -->
                    <h3>Bejegyzés 6</h3>
                    <p class="info">John Doe | 2022.11.11.</p>
                    <p class="tartalom">
                        Lorem ipsum dolor sit amet consectetur. A cikknek az első 100
                        karaktere jelenik meg itt...
                    </p>

                    <!-- Tovább olvasom gomb -->
                    <div class="col-6">
                        <a href="#">
                            <button type="button" class="btn btn-primary tovabb-olvasom">
                                Tovább olvasom
                            </button></a>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-6 col-sm-12">
                <div class="card">
                    <!-- Indexkép -->
                    <img class="img-fluid" src="/img/default_image.png" alt="Indexkép" />

                    <!-- Bejegyzés megjelenő adatai -->
                    <h3>Bejegyzés 5</h3>
                    <p class="info">John Doe | 2022.11.11.</p>
                    <p class="tartalom">
                        Lorem ipsum dolor sit amet consectetur. A cikknek az első 100
                        karaktere jelenik meg itt...
                    </p>

                    <!-- Tovább olvasom gomb -->
                    <div class="col-6">
                        <a href="#">
                            <button type="button" class="btn btn-primary tovabb-olvasom">
                                Tovább olvasom
                            </button></a>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-6 col-sm-12">
                <div class="card">
                    <!-- Indexkép -->
                    <img class="img-fluid" src="/img/default_image.png" alt="Indexkép" />

                    <!-- Bejegyzés megjelenő adatai -->
                    <h3>Bejegyzés 4</h3>
                    <p class="info">John Doe | 2022.11.11.</p>
                    <p class="tartalom">
                        Lorem ipsum dolor sit amet consectetur. A cikknek az első 100
                        karaktere jelenik meg itt...
                    </p>

                    <!-- Tovább olvasom gomb -->
                    <div class="col-6">
                        <a href="#">
                            <button type="button" class="btn btn-primary tovabb-olvasom">
                                Tovább olvasom
                            </button></a>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-6 col-sm-12">
                <div class="card">
                    <!-- Indexkép -->
                    <img class="img-fluid" src="/img/default_image.png" alt="Indexkép" />

                    <!-- Bejegyzés megjelenő adatai -->
                    <h3>Bejegyzés 3</h3>
                    <p class="info">John Doe | 2022.11.11.</p>
                    <p class="tartalom">
                        Lorem ipsum dolor sit amet consectetur. A cikknek az első 100
                        karaktere jelenik meg itt...
                    </p>

                    <!-- Tovább olvasom gomb -->
                    <div class="col-6">
                        <a href="#">
                            <button type="button" class="btn btn-primary tovabb-olvasom">
                                Tovább olvasom
                            </button></a>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-6 col-sm-12">
                <div class="card">
                    <!-- Indexkép -->
                    <img class="img-fluid" src="/img/default_image.png" alt="Indexkép" />

                    <!-- Bejegyzés megjelenő adatai -->
                    <h3>Bejegyzés 2</h3>
                    <p class="info">John Doe | 2022.11.11.</p>
                    <p class="tartalom">
                        Lorem ipsum dolor sit amet consectetur. A cikknek az első 100
                        karaktere jelenik meg itt...
                    </p>

                    <!-- Tovább olvasom gomb -->
                    <div class="col-6">
                        <a href="#">
                            <button type="button" class="btn btn-primary tovabb-olvasom">
                                Tovább olvasom
                            </button></a>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-6 col-sm-12">
                <div class="card">
                    <!-- Indexkép -->
                    <img class="img-fluid" src="/img/default_image.png" alt="Indexkép" />

                    <!-- Bejegyzés megjelenő adatai -->
                    <h3>Bejegyzés 1</h3>
                    <p class="info">John Doe | 2022.11.11.</p>
                    <p class="tartalom">
                        Lorem ipsum dolor sit amet consectetur. A cikknek az első 100
                        karaktere jelenik meg itt...
                    </p>

                    <!-- Tovább olvasom gomb -->
                    <div class="col-6">
                        <a href="#">
                            <button type="button" class="btn btn-primary tovabb-olvasom">
                                Tovább olvasom
                            </button></a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Lábléc -->
    <div class="kulso">
        <div class="container">
            <footer class="d-flex flex-wrap justify-content-between align-items-center py-3 my-4 mb-0">
                <p class="col-md-4 mb-0">
                    <a href="#" class="nav-link">Weboldal címe</a>
                </p>

                <ul class="nav col-md-4 justify-content-end">
                    <li class="nav-item">
                        <a href="#" class="nav-link px-3">Főoldal</a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link px-3">Oldal1</a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link px-3">Oldal2</a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link px-3">Bejelentkezés</a>
                    </li>
                </ul>
            </footer>
        </div>
    </div>
</body>

</html>