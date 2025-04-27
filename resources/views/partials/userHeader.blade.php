<style>
    .header-container {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 8%;
        width: 100%;
        padding: 0 20px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        background-color: rgba(28, 37, 54);
    }

    .menu-button-container i {
        color: white;
        font-size: 26px;
        cursor: pointer;
    }

    .title-container {
        margin: 0 auto 0 10px;
    }

    .title-container h1 {
        margin-bottom: -1px;
        color: #e6e6e6;
        font-family: Arial, Helvetica, sans-serif;
        cursor: pointer;
    }

    @media (max-width: 639px) {
        .menu-button-container i {
            color: white;
            font-size: large;
        }

        .title-container h1 {
            font-size: large;
        }
    }
</style>

<div class="header-container">
    <div class="menu-button-container">
        <i class="fa-solid fa-bars" id="menu-icon"></i>
    </div>
    <div class="title-container">
        <h1 onclick="window.location.href='{{ route('user.home') }}'">XTREME GYM WORLD</h1>
    </div>
</div>