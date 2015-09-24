<?php
  if(!isset($angular)) { $angular = false; }
  if(!isset($pageAngular)) { $pageAngular = false; }
  if(!isset($pageController)) { $pageController = false; }
?>
<!DOCTYPE html>
<html lang="en" @if($angular) ng-app="io.programmar" ng-controller="ProgrammarController" @endif>
  <head>
    <!-- Meta, title, CSS, favicons, etc. -->
    @include('_includes.header')
  </head>
  <body id="@yield('page')" @if($pageAngular) ng-controller="{{ $pageController }}" @endif>
    @include('_modals.login')
    @include('_modals.search')
    @yield('content')

    <!-- Scripts -->
    @include('_includes.scripts')

    <!-- Google Analytics -->
    <script>
      (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
      (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
      m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
      })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

      ga('create', 'UA-59897932-1', 'auto');
      ga('send', 'pageview');

    </script>
  </body>
</html>