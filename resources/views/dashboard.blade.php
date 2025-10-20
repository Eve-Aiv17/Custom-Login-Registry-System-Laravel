<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <title>Animated Dashboard</title>
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <style>
    /* -------- variables (CSS) -------- */
    :root{
      --overlayZLevel: 1000;
      --overlaySkewDeg: 20deg;
      /* adjust this to fit the skew width used in transforms */
      --overlaySkewWidthModifier: 72.8vh;
      --labelSkewDeg: -10deg;
      --transitionTime: 400ms;

      --bgGradientStartColor: hsl(0, 80%, 38%);
      --bgGradientEndColor: hsl(55, 80%, 60%);
    }

    /* reset */
    *{box-sizing:border-box}
    html,body{height:100%;margin:0;padding:0;font-family:system-ui,Segoe UI,Roboto,Helvetica,Arial,sans-serif}

    /* page container */
    .page{
      width:100%;
      height:100%;
      display:flex;
      justify-content:center;
      align-items:center;
      background: linear-gradient(135deg, #e14f32, #f39c12, #4facff);
    }

    /* page content blocks (Home / About) */
    .page__content{
      display:none;
      color:#fff;
      text-align:center;
      width:100%;
      max-width:720px;
      padding:40px;
    }
    .page__content--active{display:block}

    .page__content h2{margin:0 0 12px;font-size:32px}
    .page__content p{margin:0 0 18px;color:rgba(255,255,255,0.95)}

    a[data-page-link]{
      display:inline-block;
      text-decoration:none;
      border: 2px solid rgba(255,255,255,0.85);
      color:#fff;
      padding:10px 18px;
      border-radius:8px;
      transition: all 150ms ease;
      background: transparent;
      cursor:pointer;
    }
    a[data-page-link]:hover{
      background: rgba(255,255,255,0.12);
      transform: translateY(-2px);
    }

    /* -------- overlay (full-screen skewed animated panel) -------- */
    .overlay{
      z-index: var(--overlayZLevel);
      pointer-events: none; /* don't block UI */
      position: fixed;
      inset: 0;
      overflow:hidden;
      perspective:1000px;
    }

    .overlay__scene{
      /* scene is wider than viewport so skew has room */
      position:absolute;
      width: calc(100vw + var(--overlaySkewWidthModifier));
      height:100%;
      top:0;
      left: calc(-1 * var(--overlaySkewWidthModifier) / 2);
      display:flex;
      justify-content:center;
      align-items:center;
      background: linear-gradient(-20deg, var(--bgGradientStartColor), var(--bgGradientEndColor));
      transform: skew(var(--overlaySkewDeg)) translateX(calc(100% + var(--overlaySkewWidthModifier)));
      overflow:hidden;
      will-change: transform;
    }

    /* animation states (in / out) */
    .overlay__scene--in{
      animation: overlayIn var(--transitionTime) ease-in-out 1 both;
      pointer-events: none;
    }
    .overlay__scene--out{
      animation: overlayOut var(--transitionTime) ease-in-out 1 both;
      pointer-events: none;
    }

    /* label area */
    .overlay__label{
      position:absolute;
      width:200%;
      height:25vmin;
      line-height:1;
      top:50vh;
      left:-50%;
      background: hsla(0, 80%, 74%, 1);
      color: #810e0e;
      display:flex;
      justify-content:center;
      align-items:center;
      transform: skewY(var(--labelSkewDeg)) translateY(-50%);
      mix-blend-mode: multiply;
      pointer-events: none;
    }
    .overlay__label-content{
      font-size: 6vmin;
      transform: skew(calc(-1 * var(--overlaySkewDeg)));
      white-space:nowrap;
      opacity:0;
      will-change: transform, opacity;
    }

    /* label animation applied when scene is 'in' */
    .overlay__scene--in .overlay__label-content{
      animation: labelIn 900ms cubic-bezier(.2,.9,.2,1) 1 forwards;
    }

    /* keyframes (converted from SCSS) */
    @keyframes overlayIn {
      from {
        transform: skew(var(--overlaySkewDeg)) translate3d(calc(100% + var(--overlaySkewWidthModifier)), 0, 0);
      }
      to {
        transform: skew(var(--overlaySkewDeg)) translate3d(0, 0, 0);
      }
    }
    @keyframes overlayOut {
      from {
        transform: skew(var(--overlaySkewDeg)) translate3d(0, 0, 0);
      }
      to {
        transform: skew(var(--overlaySkewDeg)) translate3d(calc(-100% - var(--overlaySkewWidthModifier)), 0, 0);
      }
    }
    @keyframes labelIn {
      from {
        transform: skewY(var(--labelSkewDeg)) translateY(-50%) rotateY(calc(-1 * var(--labelSkewDeg)));
        opacity:0;
      }
      to {
        transform: skewY(var(--labelSkewDeg)) translateY(-50%) rotateY(calc(var(--labelSkewDeg)));
        opacity:1;
      }
    }

    /* nice small responsive tweaks */
    @media (max-width:640px){
      .overlay__label-content{font-size:8vmin}
      .page__content{padding:24px}
      .page__content h2{font-size:22px}
    }
  </style>
</head>
<body>

  <div class="page">
    <!-- Dashboard (page-1) -->
    <div class="page__content page__content--active" id="page-1">
      <h2>Welcome, {{ auth()->user()->name }}</h2>

      <form action="{{ route('logout') }}" method="POST" style="margin:18px 0; background:transparent">
        @csrf
        <button type="submit" style="padding:10px 16px;border-radius:8px;border:0;background:#fff;color:#333;cursor:pointer">Logout</button>
      </form>

      @if(session('success'))
        <p style="color:lightgreen">{{ session('success') }}</p>
      @endif

      <p style="opacity:.92;max-width:560px;margin:16px auto;">
        This is your dashboard. Use the link below to see the About page (animated overlay transition).
      </p>

      <div style="margin-top:22px;">
        <a data-page-link href="#page-2" title="About Page">About</a>
      </div>
    </div>

    <!-- About (page-2) -->
    <div class="page__content" id="page-2">
      <h2>About This Dashboard</h2>
      <p style="max-width:560px;margin:12px auto 20px;">Animated Laravel Dashboard Example with a full-screen skewed overlay.</p>
      <a data-page-link href="#page-1" title="Dashboard Home">Back</a>
    </div>

    <!-- Overlay Scene -->
    <div class="overlay" aria-hidden="true">
      <div class="overlay__scene">
        <div class="overlay__label">
          <div class="overlay__label-content">Label</div>
        </div>
      </div>
    </div>
  </div>

  <script>
    (function(){
      const links = document.querySelectorAll("[data-page-link]");
      const overlayScene = document.querySelector(".overlay__scene");
      const label = document.querySelector(".overlay__label-content");
      const ANIMATION_TIME = 400; // should match --transitionTime

      if(!links || !overlayScene || !label) return;

      const showOverlayAndSwitch = (target, title) => {
        // reset classes
        overlayScene.classList.remove("overlay__scene--in","overlay__scene--out");

        // set label text
        label.innerText = title || "";

        // trigger "in" animation
        void overlayScene.offsetWidth; // force reflow so animation restarts reliably
        overlayScene.classList.add("overlay__scene--in");

        // after overlay in finishes, switch content, then play out animation
        setTimeout(() => {
          const current = document.querySelector(".page__content--active");
          if (current) current.classList.remove("page__content--active");

          // small random delay to emulate "loading" then reveal target
          setTimeout(() => {
            if (target) target.classList.add("page__content--active");

            // trigger overlay out
            overlayScene.classList.remove("overlay__scene--in");
            void overlayScene.offsetWidth;
            overlayScene.classList.add("overlay__scene--out");
          }, Math.random() * 400 + 300);

        }, ANIMATION_TIME); // wait for 'in' animation to finish
      };

      links.forEach(link=>{
        const href = link.getAttribute("href");
        const title = link.getAttribute("title") || link.textContent.trim();
        const target = document.querySelector(href);

        link.addEventListener("click", e=>{
          e.preventDefault();
          if (!target) return;
          showOverlayAndSwitch(target, title);
        });
      });

      // auto-click first link to initialize (preserves active state)
      document.addEventListener("DOMContentLoaded", ()=>{
        if(links[0]) links[0].click();
      });
    })();
  </script>
</body>
</html>



