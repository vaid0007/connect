<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Under Maintenance | Connect Compusys Pvt. Ltd.</title>
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
      rel="stylesheet"
    />
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css"
      rel="stylesheet"
    />
    <style>
      /* Full-page gradient background */
      body {
        height: 100vh;
        display: flex;
        justify-content: center;
        align-items: center;
        background: linear-gradient(135deg, #0a2342, #1a73e8);
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      }

      /* White card */
      .maintenance-card {
        background: #ffffff;
        border-radius: 20px;
        padding: 3rem 2rem;
        max-width: 600px;
        text-align: center;
        box-shadow: 0 0 30px rgba(0, 0, 0, 0.3);
        animation: fadeInUp 1s ease;
      }

      @keyframes fadeInUp {
        from {
          opacity: 0;
          transform: translateY(50px);
        }
        to {
          opacity: 1;
          transform: translateY(0);
        }
      }

      /* Card content styles */
      .maintenance-card h1 {
        font-size: 2.5rem;
        font-weight: 700;
        margin-bottom: 1rem;
        color: #000000;
      }

      .maintenance-card p {
        font-size: 1.1rem;
        color: #000000;
      }

      .maintenance-card .logo {
        max-width: 120px;
        margin-bottom: 1.5rem;
      }

      .btn-contact {
        margin-top: 1.5rem;
      }

      .footer {
        margin-top: 1.5rem;
        font-size: 0.85rem;
        color: #555555;
      }
    </style>
  </head>
  <body>
    <div class="maintenance-card">
      <img src="images/logo.png" alt="CCPL Logo" class="logo" />
      <h1>Happy diwali to all<br/>We'll be back soon!</h1>
      <p>
        Connect Compusys Pvt. Ltd. is currently undergoing scheduled maintenance.
        <br />
        We apologize for the inconvenience and appreciate your patience.
      </p>
      <p class="mt-2 mb-3">
        Established in 1996, CCPL delivers cutting-edge solutions in
        Telecommunications, Signaling, IT & Electrification for Metro Rail systems.
      </p>
      <a href="mailto:info@ccpl.com" class="btn btn-primary btn-lg btn-contact">
        Contact Us
      </a>
      <div class="footer">
        &copy; 1996 - 2025 Connect Compusys Pvt. Ltd.
      </div>
    </div>

    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    ></script>
  </body>
</html>
