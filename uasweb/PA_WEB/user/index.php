<?php
  require '..\koneksi.php'; 
  session_start();

  $tampil  = "SELECT * FROM produk ";
  $hasi    = mysqli_query($db, $tampil);
  $jumlah  = mysqli_num_rows($hasi);

  if (!isset($_SESSION['username'])) {
    header("Location: LOG-IN.php");}

//   $tampil = "SELECT * FROM tb_produk ";
//   if( isset($_POST["cari"])){
//     $nama_dicari = $_POST["keyword"];
//     $tampil = "SELECT *FROM tb_produk WHERE gambar      LIKE '%$nama_dicari%' OR
//                                             nama        LIKE '%$nama_dicari%' OR
//                                             harga       LIKE '%$nama_dicari%' OR
//                                             stok        LIKE '%$nama_dicari%' OR
//                                             desk        LIKE '%$nama_dicari%' OR
//                                             kategori    LIKE '%$nama_dicari%' OR
//                                             id_produk   LIKE  '%$nama_dicari%'";
// }
if( isset($_POST["cari"])){
  $nama_dicari = $_POST["keyword"];
  $select_sql = "SELECT pembelian.id_pembelian ,pembelian.tanggal, 
                produk.gambar, user.username,pembelian.jumlah, pembelian.harga,
                produk.deskripsi,produk.kategori FROM pembelian
                INNER JOIN user on pembelian.id_user = user.id_user
                INNER JOIN produk on pembelian.id_produk = produk.id_produk
                WHERE (id_pembelian       LIKE '%$nama_dicari%' OR
                      jumlah        LIKE '%$nama_dicari%' OR
                      tanggal       LIKE '%$nama_dicari%' OR
                      harga         LIKE '%$nama_dicari%' OR
                      deskripsi     LIKE '%$nama_dicari%' OR 
                      kategori      LIKE '%$nama_dicari%')";}
  
?>  
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/6acc3fbd7c.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" >
    <title>Produk</title>
    <!-- <link rel="icon" href="https://www.freepnglogos.com/uploads/honda-logo-png/honda-motorcycles-logo-wing-10.png"> -->
</head>
<html>
<body>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
   
  <section id="home">
  <nav>
    <ul>
    <?php if(isset($_SESSION['username'])){
    }if($_SESSION['username']){
        echo "<li><a href='profil_user.php'><i class='fa-solid fa-user'></i> Profile</a></li>";
    }
    ?>
    
    </a></li> 
   
    <li><a href="keranjang.php"><i class="fa-solid fa-cart-shopping"></i> Keranjang</a></li>
    <li><a href="#about">About</a></li>
    <li><a href="#home">Home</a></li>
    <img src="..\img/logoo.png" alt="kueLogo" class="logo" width ="150px">
   
    
  </ul> 
  </nav>
  <div class ="header2">
     <div class="header-logo2">  Cari sesuai dengan keinginan anda </div>
       
      <form METHOD="POST" >
        <input class="srch" type="text" name="keyword"  placeholder="Masukan Keyword .   . . . ">
        <button  class="create" type="submit" name="cari"><i class="fas fa-search"></i> Cari Kata</button>
      </form>
    
    </div>
    <div class="gari">
      <p class="info">Produk</p>
    </div>

    
    <?php 
    $halperpage = 5;
    $page = isset($_GET["halaman"]) ? (int)$_GET["halaman"] : 1;
    $mulai = ($page>1) ? ($page * $halperpage) - $halperpage : 0;
    $sebelum = $page-1;
    $setelah = $page+1;
    $tampil  = "SELECT * FROM produk ";
    $hasi    = mysqli_query($db, $tampil);
    $jumlah  = mysqli_num_rows($hasi);
    $pages = ceil($jumlah/$halperpage);            
    $query = mysqli_query($db,"SELECT * FROM produk LIMIT $mulai, $halperpage")or die(mysqli_error);
    $no = $mulai+1;
    ?> 


<div class="container-card">
 
  <?php
  if($jumlah > 0){
    while($row = mysqli_fetch_assoc($hasi)){
  ?>
    <div class="card">
          <img src="..\img/<?=$row['gambar']?>" alt="gambar_produk" width="150px" class="gbrkue">
          <h5><?= $row['kategori'] ?></h5>
          <p class="price">Rp.<?= $row['harga']?></p>
          <p><?= $row['deskripsi']?></p>
          <a href="beli_produk.php?id_produk=<?php echo $row['id_produk']?>"class="masukan"><i class="fa-solid fa-cart-plus"></i></a>
          <a href="cekout.php?id_produk=<?php echo $row['id_produk']?>"><button class="cekout">Beli</button></a>
      </div>
  <?php
      }
  }
  ?>

</div>
<div class="next">
      <ul class="pagination">
        <li class="page-item">
          <a class="page-link" <?php if($page > 1){ echo "href='?halaman=$sebelum'"; } ?>>Previous</a>
        </li>
        <?php 
          for($i = 1; $i <= $pages; $i++){
        ?> 
        <li class="page-item"><a class="page-link" href="?halaman=<?php echo $x ?>"> <?php echo $i; ?></a></li>
        <?php
          }
        ?> 
        <li class="page-item">
          <a  class="page-link" <?php  if($page < $pages) { echo "href='?halaman=$setelah'"; } ?>>Next</a>
        </li>
      </ul>
      </div>

  </div> 
</div>
  

    <footer class=" footer">
      <section id="about">
      <div class ="footer-container">
      <div class="row">
      <img src="https://serbasepeda.com/assets/frontend/images/logo-serbasepeda.svg" alt="SerbaSepeda Logo" class="image">
        <div class ="footer-nav-section" >
          <h4 class ="heading">Serba Sepeda</h4>
          <ul class="items">
            <li class="item"><a href="#">Tentang Kami</a></li> 
            <li class="item"><a href="#"> Blog serba sepeda</a></li> 
            <li class="item"><a href="#"> daftar brand </a></li> 
            <li class="item"><a href="#">promosi </a></li> 
            <li class="item"><a href="#">garansi seumur hidup</a></li> 
            <li class="item"><a href="#">reward point & referal </a></li>
            <li class="item"> <a href="#">service sepeda </a></li> 
            <li class="item"><a href="#">lowongan kerja </a></li> 
          </ul>
      </div>
        <div class=" footer-nav-section">
          <h4 class ="heading"> Get Help</h4>
          <ul class =" items">  
            <li class="item" > <a href="#">FAQ(Frequently Asked Question</a></li> 
            <li class="item"><a href="#">syarat dan ketentuan</a></li> 
            <li class="item"> <a href="#">konfirmasi pembayaran</a></li> 
            <li class="item"> <a href="#">cara berbelanja</a></li> 
            <li class="item"> <a href="#">syarat dan cara kredit sepeda</a></li> 
            <li class="item"><a href="#">hubungi kami</a></li> 
          </ul>
        </div>
        <div class="footer-nav-section">
          <div class="media">
          <h4 class ="heading">Follow Us</h4>
            <ul class="media-items">
              <li><a href="https://wa.me/6281254424739"><i class="fa1 fas fa-phone"></i> Contact</a></li>
              <li><a href="https://twitter.com/Cnoxerr12345"><i class="fa1 fa-brands fa-twitter"></i> Twiter</a></li>
              <li><a href="https://www.instagram.com/ash4rr/"><i class="fa1 fa-brands fa-instagram"></i> Instagram</a></li>
            </ul>
        </div>
      </div>
    </div>
    </div>
  </section>
  </footer>
  </section>
</body>
</html>

<style>
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');

*{
    margin: 0;
    padding: 0;
}
body{
    font-family: 'Poppins', sans-serif;

}
.logo{
    margin-top: 15px;
    margin-left:5px;
}
.header2{
   
  background-image: linear-gradient(to left,#FFF0F5,#E0FFFF);
   height: 50px;
  }
/* tulisan header2 */
.header-logo2{
    font-family: 'Nunito', sans-serif;
    font-size:20px;
    float: left;
    height : 30px;
    padding: 10px 30px;
    color:black;
    color:#505091;
  font-family: 'Cormorant', serif;
}

   /* form searching */
.srch{ 
  
   border: 1px;
   display: inline-block;
   width: 50%; 
   height:30%; 
   margin-top: 30px;color:white; 
  color: black;
  text-align: center;
  padding :10px;
  display: inline-block;
  font-size: 16px;
  border-radius:10px;

}
.create{
  margin-left:80px;
  color:white;
  background-color: #4CAF50; 
  border: 4px;
  color: white;
  text-align: center;
  text-decoration: none;
  padding :10px;
  display: inline-block;
  font-size: 16px;
  cursor: pointer;
  border-radius:10px;
}
.placholder{
   border: 1px solid rgb(8, 208, 172);

}
.container-card{
  display: flex;
  flex-wrap: wrap;
}
.card {
  flex: 0 1 24%;
  box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
  max-width: 300px;
  margin: auto;
  margin-bottom:35px;
  text-align: center;
}
.gbrkue{
  margin-left:70px;
  margin-top:15px;
}
.price {
  color: grey;
  font-size: 15px;
}
.masukan {  
  border: none;
  outline: 0;
  padding: 10px;
  margin-top: 3px;
  color: white;
  background-color: #145ba3;
  cursor: pointer;
  width: 20%;
  margin-left: 20px;
  margin-top:10px;
  border-radius: 5px;
  font-size: 18px;

}

.cekout {  
  border: none;
  outline: 0;
  padding: 10px;
  color: white;
  background-color: #fb8c00;
  text-align: center;
  cursor: pointer;
  width: 20%;
  height:45px;
  margin-left: 30px;
  margin-bottom:15px;
  font-size: 18px;
  border-radius: 5px;
}

input[type=text] {
  margin-right:-65px;
  padding: 3.5px;
  margin-top: 8px;
  font-size: 15px;
  font-family: 'Poppins', sans-serif;


  
}
nav{

  height:200px;
  /* background-color:#dee3ff;
  border-bottom: 50px solid #dee7ec; */
  background-image: linear-gradient(to bottom, #E0FFFF,#E6E6FA );
  /* background-image: linear-gradient(to left,#C0C0C0,#FFF5EE); */
  border-bottom: 50px linear-gradient(to left , #A0F1EA,#EAD6EE);
}

nav ul {
  list-style-type: none;
  margin: 0;
  font-size:20px;
  overflow: hidden;
  height: 150px;
  font-family: 'Nunito', sans-serif;
  padding : 33px 20px;
  padding-left:10px;
}
ul li a:hover{
    color: #145ba3;
    padding-left:10px;
  }

nav ul li {
  float: right;
}

nav ul li a {
  display: block;
  color:black;
  text-align: center;
  padding: 14px 16px;
  text-decoration: none;
}

.info{
  color:#505091;
  font-size:22px;
  padding-left:22px;
  margin-top:50px;
  font-family: 'Cormorant', serif;
  font-size:50px;
  border-bottom: 2px solid #dee7ec;
}


table {
  border-collapse: collapse;
  width: 90%;
  margin: auto;}

th, td {
  text-align: left;
  padding: 8px;
  border-bottom:1px solid #cad1db;

}

th {
  background-color: #242020;
  color: white;
}
.footer{
  /* background-color:#4a4a4a; */
  color: white;
  padding:50px 30px;
  border-top: 50px solid #dee7ec;
  background-image: linear-gradient(to left,#778899,#4a4a4a);
  background-image: linear-gradient(to bottom,#778899,#4a4a4a);
  
}
.footer-container{
  max-width:1170px;
  margin:auto;

}
.row{
  display: flex;
  flex:wrap;
}
.footer ul{
  list-style:none;
}
.footer-nav-section{
  width: 25%;
  padding: 0 25px;
}
.footer-nav-section h4{
  font-size: 18px;
  text-transform: capitalize;
  margin-bottom:15px;
  font-family: 'Poppins', sans-serif;
  font-style: bold;
}
.footer-nav-section ul li:not(:last-child){
  margin-bottom:10px;
}
.footer-nav-section ul li a{
  font-size:16px;
  text-decoration:none;
  color: #ffffff;
  font-weight:300;
  color:#bbbb;
  display:block;
}
.footer-nav-section ul li a:hover{
  color: #ffffff;
  padding-left:10px;
}
/* responsive
@media (max-width: 638px) {
  .masukan {  
  border: none;
  outline: 0;
  padding: 10px;
  color: white;
  background-color: #145ba3;
  cursor: pointer;
  margin-left: -15px;
  font-size: 18px;
}
}
@media (max-width: 757px) {
  .masukan {  
  border: none;
  outline: 0;
  padding: 10px;
  color: white;
  background-color: #145ba3;
  cursor: pointer;
  margin-left: -15px;
  font-size: 18px;
}
}

@media (max-width: 1021px) {
  .masukan {  
  border: none;
  outline: 0;
  padding: 10px;
  color: white;
  background-color: #145ba3;
  cursor: pointer;
  margin-left: -15px;
  font-size: 18px;
}
}
@media (min-width: 1194px) {
  .logo{
    margin-top: -39px;
    margin-left:-22px;
  }
}
@media (min-width: 377px) {
  .logo{
    margin-top: -99px;
    margin-left:-22px;
  }

  .info{
    font-size:50px;
  padding-left:22px;
  margin-top:50px;

  }
  .masukan {  
  border: none;
  outline: 0;
  padding: 10px;
  color: white;
  background-color: #145ba3;
  cursor: pointer;
  margin-left: -12px;
  font-size: 18px;
}

}

@media (min-width: 916px) {
  .logo{
    margin-top: -30px;
    margin-left:12px;
  }   
}
@media (min-width: 529px) {
  .logo{
    margin-top: -42px;
    margin-left:12px;
  }   
}

@media(max-width:767px){
  .footer-nav-section {
  width: 50%;
  margin-bottom:30px;

  }
}
@media(max-width:574px){
  .footer-nav-section {
  width: 100%;
  margin-bottom:30px;

  }
}
@media (max-width: 638px) {
  .srch{
    margin-left: -15px;
  }
  .create{
    /* margin-left: -15px; */
    /* font-size:16px;;
    padding: 5px;
  } */

  /* .header-logo2{
    font-family: 'Nunito', sans-serif;
    font-size:20px;
    float: left;
    height : 30px;
    color:black;
    color:#505091;
  font-family: 'Cormorant', serif;
  }
} */
/* @media (max-width: 757px) {
  .srch{
    margin-left: -15px;
  }
  .create{
    /* margin-left: -15px; */
    /* padding: 5px;
    font-size:16px;; */
  /* }
  .header-logo2{
    font-family: 'Nunito', sans-serif;
    font-size:20px;
    float: left;
    height : 30px;
    padding: 10px 30px;
    color:black;
    color:#505091;
  font-family: 'Cormorant', serif;
  }
} */ */
/* @media (max-width: 1021px) {
  .srch{
    margin-left: -15px;
  }
  .create{
    /* margin-left: -15px; */
    /* font-size:16px;;
    padding: 5px;
  }

  .header-logo2{
    font-family: 'Nunito', sans-serif;
    font-size:20px;
    float: left;
    height : 30px;
    color:black;
    color:#505091;
  font-family: 'Cormorant', serif;
  }} */ */
/* @media (min-width: 1194px) {
  .srch{
    margin-left: -15px;
  }
  .create{
    /* margin-left: -15px; */
    /* padding: 5px;
    font-size:16px;;
  }
  .header-logo2{
    font-family: 'Nunito', sans-serif;
    font-size:20px;
    float: left;
    height : 30px;
    color:black;
    color:#505091;
  font-family: 'Cormorant', serif;
  }
} */ */
/* @media (min-width: 377px) {  
  .srch{
    margin-left: -15px;
  }
  .create{
    /* margin-left: -15px; */
    /* padding: 5px;
    font-size:16px;;
  } */
  /* .header-logo2{
  padding-left:22px;
  font-family: 'Nunito', sans-serif;
    font-size:20px;
    float: left;
    height : 30px;
    color:black;
    color:#505091;
  font-family: 'Cormorant', serif;
  }} */ */ */
</style>


