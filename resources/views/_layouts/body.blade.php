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
  </body>
</html>