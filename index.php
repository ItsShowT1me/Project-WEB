<?php
session_start();

  include 'function.php';
  include 'connection.php';
  
  
  //$user_data = check_login($con);


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BUMBTI</title>

    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="index-style.css">
</head>
<body>
  <div class="container">
    <header class="d-flex flex-wrap align-items-center justify-content-center justify-content-md-between py-3 mb-4 border-bottom">
      <div class="col-md-3 mb-2 mb-md-0"></div>

      <ul class="nav col-12 col-md-auto mb-2 justify-content-center mb-md-0">
        <li><a href="#" class="nav-link px-5">Home</a></li>
        <li><a href="#" class="nav-link px-5">/</a></li>
        <li><a href="#" class="nav-link px-5">About</a></li>
      </ul>

      <div class="col-md-3 text-end">
        <a href="login.html" class="btn btn-outline-primary me-2">Login</a>
      </div>
    </header>
  </div>

  <!-- Sidebar -->
  <nav id="sidebar">
    <a href="#" class="brand">
      <span class="text">Find you the MBTI.</span>
    </a>

    <ul class="sidebar-menu">
      <li><a href="#"><i class="bx bxs-home"></i><span class="text">Main</span></a></li>
      <li><a href="#"><i ></i><span class="text">ISTJ - The Inspector</span></a></li>
      <li><a href="#"><i ></i><span class="text">ISFJ - The Protector</span></a></li>
      <li><a href="#"><i ></i><span class="text">INFJ - The Advocate</span></a></li>
      <li><a href="#"><i ></i><span class="text">INTJ - The Mastermind</span></a></li>
      <li><a href="#"><i ></i><span class="text">ISTP - The Virtuoso</span></a></li>
      <li><a href="#"><i ></i><span class="text">ISFP - The Composer</span></a></li>
      <li><a href="#"><i ></i><span class="text">INFP - The Mediator</span></a></li>
      <li><a href="#"><i ></i><span class="text">INTP - The Architect</span></a></li>
      <li><a href="#"><i ></i><span class="text">ESTP - The Dynamo</span></a></li>
      <li><a href="#"><i ></i><span class="text">ESFP - The Performer</span></a></li>
      <li><a href="#"><i ></i><span class="text">ENFP - The Campaigner</span></a></li>
      <li><a href="#"><i ></i><span class="text">ENTP - The Debater</span></a></li>
      <li><a href="#"><i ></i><span class="text">ESTJ - The Executive</span></a></li>
      <li><a href="#"><i ></i><span class="text">ESFJ - The Consul</span></a></li>
      <li><a href="#"><i ></i><span class="text">ENFJ - The Protagonist</span></a></li>
      <li><a href="#"><i ></i><span class="text">ENTJ - The Commander</span></a></li>
      <li><a href="#"><i class="bx bx-log-out"></i><span class="text">Logout</span></a></li>
    </ul>
  </nav>
  

  <div class="main">

    <div class="search-container">
      <input type="text" id="searchBox" class="search-input" placeholder="search MBTI...">
      <div id="results" class="search-results"></div>
    </div>

      <!-- Modal สำหรับแสดง PDF -->
  <div id="pdfModal" class="modal">
    <div class="modal-content">
      <span class="close">&times;</span>
      <iframe id="pdfFrame" src="" width="100%" height="500px"></iframe>
    </div>
  </div>
  

  <section class="album">
      <div class="container-card">
        <div class="row">
          <!-- ตัวอย่างการ์ด -->
          <div class="card">
            <div class="card-image"></div>
            <div class="card-body">
              <p class="card-text">This is a card with some sample text to display layout without Bootstrap.</p>
              <div class="card-actions">
                <button class="view-btn" data-pdf="files/sample.pdf">View</button>
                <button class="add-to-cart-btn" data-item="Item Name">Add to cart</button>
              </div>
            </div>
          </div>
          
          <div class="card">
            <div class="card-image"></div>
            <div class="card-body">
              <p class="card-text">This is a card with some sample text to display layout without Bootstrap.</p>
              <div class="card-actions">
                <button class="view-btn" data-pdf="files/sample.pdf">View</button>
                <button class="add-to-cart-btn" data-item="Item Name">Add to cart</button>
              </div>
            </div>
          </div>

          <div class="card">
            <div class="card-image"></div>
            <div class="card-body">
              <p class="card-text">This is a card with some sample text to display layout without Bootstrap.</p>
              <div class="card-actions">
                <button class="view-btn" data-pdf="files/sample.pdf">View</button>
                <button class="add-to-cart-btn" data-item="Item Name">Add to cart</button>
              </div>
            </div>
          </div>

          <div class="card">
            <div class="card-image"></div>
            <div class="card-body">
              <p class="card-text">This is a card with some sample text to display layout without Bootstrap.</p>
              <div class="card-actions">
                <button class="view-btn" data-pdf="files/sample.pdf">View</button>
                <button class="add-to-cart-btn" data-item="Item Name">Add to cart</button>
              </div>
            </div>
          </div>

          <div class="card">
            <div class="card-image"></div>
            <div class="card-body">
              <p class="card-text">This is a card with some sample text to display layout without Bootstrap.</p>
              <div class="card-actions">
                <button class="view-btn" data-pdf="files/sample.pdf">View</button>
                <button class="add-to-cart-btn" data-item="Item Name">Add to cart</button>
              </div>
            </div>
          </div>

          <div class="card">
            <div class="card-image"></div>
            <div class="card-body">
              <p class="card-text">This is a card with some sample text to display layout without Bootstrap.</p>
              <div class="card-actions">
                <button class="view-btn" data-pdf="files/sample.pdf">View</button>
                <button class="add-to-cart-btn" data-item="Item Name">Add to cart</button>
              </div>
            </div>
          </div>

          <div class="card">
            <div class="card-image"></div>
            <div class="card-body">
              <p class="card-text">This is a card with some sample text to display layout without Bootstrap.</p>
              <div class="card-actions">
                <button class="view-btn" data-pdf="files/sample.pdf">View</button>
                <button class="add-to-cart-btn" data-item="Item Name">Add to cart</button>
              </div>
            </div>
          </div>

          <div class="card">
            <div class="card-image"></div>
            <div class="card-body">
              <p class="card-text">This is a card with some sample text to display layout without Bootstrap.</p>
              <div class="card-actions">
                <button class="view-btn" data-pdf="files/sample.pdf">View</button>
                <button class="add-to-cart-btn" data-item="Item Name">Add to cart</button>
              </div>
            </div>
          </div>

          <div class="card">
            <div class="card-image"></div>
            <div class="card-body">
              <p class="card-text">This is a card with some sample text to display layout without Bootstrap.</p>
              <div class="card-actions">
                <button class="view-btn" data-pdf="files/sample.pdf">View</button>
                <button class="add-to-cart-btn" data-item="Item Name">Add to cart</button>
              </div>
            </div>
          </div>

          <div class="card">
            <div class="card-image"></div>
            <div class="card-body">
              <p class="card-text">This is a card with some sample text to display layout without Bootstrap.</p>
              <div class="card-actions">
                <button class="view-btn" data-pdf="files/sample.pdf">View</button>
                <button class="add-to-cart-btn" data-item="Item Name">Add to cart</button>
              </div>
            </div>
          </div>

          <div class="card">
            <div class="card-image"></div>
            <div class="card-body">
              <p class="card-text">This is a card with some sample text to display layout without Bootstrap.</p>
              <div class="card-actions">
                <button class="view-btn" data-pdf="files/sample.pdf">View</button>
                <button class="add-to-cart-btn" data-item="Item Name">Add to cart</button>
              </div>
            </div>
          </div>

          <div class="card">
            <div class="card-image"></div>
            <div class="card-body">
              <p class="card-text">This is a card with some sample text to display layout without Bootstrap.</p>
              <div class="card-actions">
                <button class="view-btn" data-pdf="files/sample.pdf">View</button>
                <button class="add-to-cart-btn" data-item="Item Name">Add to cart</button>
              </div>
            </div>
          </div>

          <div class="card">
            <div class="card-image"></div>
            <div class="card-body">
              <p class="card-text">This is a card with some sample text to display layout without Bootstrap.</p>
              <div class="card-actions">
                <button class="view-btn" data-pdf="files/sample.pdf">View</button>
                <button class="add-to-cart-btn" data-item="Item Name">Add to cart</button>
              </div>
            </div>
          </div>

          <div class="card">
            <div class="card-image"></div>
            <div class="card-body">
              <p class="card-text">This is a card with some sample text to display layout without Bootstrap.</p>
              <div class="card-actions">
                <button class="view-btn" data-pdf="files/sample.pdf">View</button>
                <button class="add-to-cart-btn" data-item="Item Name">Add to cart</button>
              </div>
            </div>
          </div>

          <div class="card">
            <div class="card-image"></div>
            <div class="card-body">
              <p class="card-text">This is a card with some sample text to display layout without Bootstrap.</p>
              <div class="card-actions">
                <button class="view-btn" data-pdf="files/sample.pdf">View</button>
                <button class="add-to-cart-btn" data-item="Item Name">Add to cart</button>
              </div>
            </div>
          </div>

          <div class="card">
            <div class="card-image"></div>
            <div class="card-body">
              <p class="card-text">This is a card with some sample text to display layout without Bootstrap.</p>
              <div class="card-actions">
                <button class="view-btn" data-pdf="files/sample.pdf">View</button>
                <button class="add-to-cart-btn" data-item="Item Name">Add to cart</button>
              </div>
            </div>
          </div>

          

          <!-- เพิ่มการ์ดอื่น ๆ ได้ที่นี่ -->
        </div>
      </div>
    </section>
  </div>

  <!-- Footer -->
  <div class="container-footer">
    <footer class="row row-cols-5 row-cols-sm-2 row-cols-md-5 py-5 my-5 border-top">
      <div class="col mb-3"></div>
      <div class="col mb-3"></div>

      <div class="col mb-3">
        <h5>Section</h5>
        <ul class="nav flex-column">
          <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-body-secondary">Home</a></li>
          <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-body-secondary">Features</a></li>
          <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-body-secondary">About</a></li>
        </ul>
      </div>

      <div class="col mb-3">
        <h5>Help</h5>
        <ul class="nav flex-column">
          <li class="nav-item mb-2"><a href="contact-us.html" class="nav-link p-0 text-body-secondary">Contact Us</a></li>
        </ul>
      </div>
    </footer>
  </div>

  

  <script src="index.js"></script>
  <script src="js/bootstrap.min.js"></script>
</body>
</html>