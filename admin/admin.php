<?php
include __DIR__ . "/../lib/utils.php";
$pdo = connect_mysql();
$sql = "SELECT * FROM articles";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$pages = [];
while ($page = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $pages[] = $page;
}
foreach ($pages as $page) {
    echo $page['title'] . "<br>";
}
print_r($page);
?>
<!-- echo $page['title'];
    echo $page['content'];
    echo $page['description'];
    echo $page['date'];
    echo $page['author'];
    echo $page['category'];
    echo $page['image'];
    echo $page['article_id']; -->
<!DOCTYPE html>
<html lang="hu">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <!-- Bootstrap behívása -->
    <link rel="stylesheet" href="../css/bootstrap/css/bootstrap.min.css" />
    <script src="../css/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Font Awesome behívása -->
    <script src="https://kit.fontawesome.com/df92ea1e57.js" crossorigin="anonymous"></script>

    <!-- Saját CSS behívása -->
    <link rel="stylesheet" href="../css/admin.css" />
    <title>Vezérlőpult</title>
</head>

<body>
    <header class="d-flex flex-wrap justify-content-center py-1 border-bottom">
        <!-- Weboldal főcímének megjelenítése -->
        <div class="d-flex align-items-center mb-md-0 me-md-auto">
            <span class="fs-4"><a href="#" class="text-dark text-decoration-none"><i
                        class="fa-solid fa-house px-3"></i></a><a href="#"
                    class="text-dark text-decoration-none">Vezérlőpult</a></span>
        </div>

        <!-- Navigációs sor hivatkozásai -->
        <div class="dropdown d-flex">
            <a href="#" class="d-flex align-items-center link-dark text-decoration-none" data-bs-toggle="dropdown"
                aria-expanded="false">
                <strong class="px-2">Vezetéknév Keresztnév</strong>
                <img src="../img/default_profile_picture.png" alt="" width="32" height="32"
                    class="rounded-circle me-2 profile_pic" />
            </a>
            <ul class="dropdown-menu text-small shadow">
                <li>
                    <a class="dropdown-item" href="#">Saját bejegyzések megtekintése</a>
                    <a class="dropdown-item" href="#">Saját profil szerkesztése</a>
                </li>
                <li>
                    <hr class="dropdown-divider" />
                </li>
                <li><a class="dropdown-item" href="#">Kijelentkezés</a></li>
            </ul>
        </div>
    </header>

    <!-- A navigációs soron kívüli tartalmi rész -->
    <div class="befoglalo">
        <!-- Oldalsó sáv -->
        <div class="d-flex flex-column flex-shrink-0 p-3 oldalsav_div" style="width: 280px">
            <a href="/" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto link-dark text-decoration-none">
                <span class="fs-4">Portál kezelése</span>
            </a>
            <hr />
            <ul class="nav nav-pills flex-column mb-auto oldalsav">
                <li class="nav-item">
                    <a href="#" class="nav-link link-dark" aria-current="page">
                        <i class="fa-solid fa-gauge-high icon"></i> Vezérlőpult
                    </a>
                </li>
                <hr />
                <li>
                    <a href="#" class="nav-link link-dark">
                        <i class="fa-solid fa-user icon"></i>
                        Profilom
                    </a>
                </li>
                <hr />
                <li>
                    <a href="#" class="nav-link link-dark">
                        <i class="fa-solid fa-gears icon"></i>
                        Portál kezelése
                    </a>
                </li>
                <li>
                    <a href="#" class="nav-link link-dark">
                        <i class="fa-solid fa-users icon"></i>
                        Felhasználók
                    </a>
                </li>
                <hr />
                <li>
                    <a href="#" class="nav-link active">
                        <i class="fa-solid fa-file-lines icon"></i>
                        Oldalak
                    </a>
                </li>
                <li>
                    <a href="#" class="nav-link link-dark">
                        <i class="fa-solid fa-pen icon"></i>
                        Bejegyzések
                    </a>
                </li>

                <hr />
                <li>
                    <a href="#" class="nav-link link-dark">
                        <i class="fa-solid fa-house icon"></i>
                        Vissza az oldalra
                    </a>
                </li>
                <li>
                    <a href="#" class="nav-link link-dark">
                        <i class="fa-solid fa-right-from-bracket icon"></i>
                        Kijelentkezés
                    </a>
                </li>
            </ul>
        </div>

        <!-- Tartalom -->
        <div class="container-fluid">
            <div class="row elsosor">
                <div class="col-6">
                    <h3>Bejegyzések kezelése</h3>
                </div>
                <div class="col-6">
                    <button class="btn btn-secondary hozzaadas">Új hozzáadása</button>
                </div>
            </div>
            <!-- Adatokat megjelenítő táblázat -->
            <table class="table table-responsive">
                <!-- Táblázat adatai -->
                <thead>
                    <tr>
                        <th class="id">ID</th>
                        <th>Bejegyzés címe</th>
                        <th>Állapot</th>
                        <th>Létrehozás dátuma</th>
                        <th>Legutóbbi módosítás</th>
                        <th>Szerző</th>
                        <th>Kezelés</th>
                    </tr>
                </thead>
                <!-- Tartalmak megjelenítése -->
                <tbody>
                    <tr>
                        <td class="id">5</td>
                        <td>Kirándulás</td>
                        <td>Nyilvános</td>
                        <td>2022.11.08.</td>
                        <td>John Doe ~ 2022.11.11.</td>
                        <td>Vezetéknév Keresztnév</td>
                        <td>
                            <a class="btn btn-success kezeles" href="#" target="_blank">
                                <i class="fa-solid fa-eye"></i></a><a class="btn btn-primary kezeles" href="#">
                                <i class="fa-solid fa-edit"></i></a><a class="btn btn-danger kezeles" href="#">
                                <i class="fa-solid fa-ban"></i>
                            </a>
                        </td>
                    </tr>


                </tbody>
            </table>
            <!-- Lapozás a következő oldalra -->
            <div class="lapoz">
                <span class="px-3">Megjelenítve: <b>1-5</b>/23</span>
                <button class="btn btn-secondary">
                    <i class="fa-solid fa-arrow-left"></i>
                </button>
                <button class="btn btn-secondary">
                    <i class="fa-solid fa-arrow-right"></i>
                </button>
            </div>
        </div>
    </div>
</body>

</html>