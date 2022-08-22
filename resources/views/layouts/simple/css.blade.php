@yield('css')
<!-- Bootstrap Css -->
<link href="{{ asset('assets/css/bootstrap.css') }}" id="bootstrap-style" rel="stylesheet" type="text/css" />
<!-- Icons Css -->
<link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
<!-- App Css-->
<link href="{{ asset('assets/css/app.css') }}" id="app-style" rel="stylesheet" type="text/css" />

<style>
    .searching__container {
        position: relative;
    }
    .searching__container:focus-within .searching {
        opacity: 1;
        visibility: visible;
    }
    .searching__container:hover .searching {
        opacity: 1;
        visibility: visible;
    }
    .searching {
        position: absolute;
        left: 0;
        padding: 20px;
        margin-top: 15px;
        border-radius: .25rem;
        width: 100%;
        border: 1px solid rgba(255, 255, 255, .5);
        opacity: 0;
        visibility: hidden;
        transition: .3s all;
    }
    .searching li {
        margin-bottom: 10px;
        width: 100%;
        list-style-type: none;
        display: flex;
        align-items: center;
        justify-content: flex-start;
        padding-bottom: 10px;
        border-bottom: 1px solid rgba(255, 255, 255, .2);
    }
    .searching li button {
        position: relative;
        margin-right: 10px;
        color: #ffffff;
        border: none;
        border-radius: 0.1rem;
        width: 25px;
        height: 25px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .searching li:last-child {
        margin-bottom: 0;
    }



    .popup__add {
        display: block;
        position: fixed;
        transition: all .2s ease-out;
        width: 280px;
        height: 100vh;
        z-index: 9999;
        float: right!important;
        /*right: -290px;*/
        right: 0;
        top: 0;
        bottom: 0;
    }
    .popup__add .card {
        background-color: #303755 !important;
    }
    .popup__add.true {
        display: block;
    }
    .popup__add.false {
        display: none;
    }
    .popup__add .card {
        height: 100vh;
    }
    .popup__add .card-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .width__100 {
        width: 100vw;
    }
    .width__25 {
        width: 25vw;
    }
    .width__50 {
        width: 50vw;
    }
    .width__75 {
        width: 75vw;
    }

    @media  (max-width: 700px) {
        .width__100 {
            width: 100vw;
        }
        .width__25 {
            width: 100vw;
        }
        .width__50 {
            width: 100vw;
        }
        .width__75 {
            width: 100vw;
        }
    }
</style>