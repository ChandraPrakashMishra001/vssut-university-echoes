<footer class="site-footer">
  <p>
    Made with <span class="heart">❤</span> by <strong>Chandra Prakash Mishra</strong> |
    &copy; <?php echo date("Y"); ?>  VSSUT University Echoes. All rights reserved.
  </p>
</footer>

<style>
  .site-footer {
    text-align: center;
    padding: 15px 0;
    background-color: var(--primary-color);
    color: #fff;
    font-size: 1rem;
    margin-top: 40px;
    position: relative;
    z-index: 10;
  }

  .site-footer .heart {
    color: #ff4d6d;
    animation: pulse 1.2s infinite;
  }
  @keyframes pulse {
    0% { transform: scale(1); opacity: 0.9; }
    50% { transform: scale(1.3); opacity: 1; }
    100% { transform: scale(1); opacity: 0.9; }
  }
</style>

<script src="/university_platform/assets/js/script.js"></script>
</body>
</html>