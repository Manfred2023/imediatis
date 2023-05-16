<?php
session_start();
if($_SESSION['auth'] != 'ok'){
    header('location:login.php');
    exit();
}
include('header.php');
/* include('navbar.php'); */
include('menu.php');
include('../conf.php');
?>

<head>
<link rel="stylesheet" type="text/css" href="../lib/assets/css/style.css">
</head>
 <!-- Bootstrap Toasts with Placement -->
 <div class="card mb-4 mt-4">
                <!-- <h5 class="card-header">Bootstrap Toasts Example With Placement</h5> -->
                <div class="card-body">
                  <div class="row gx-3 gy-2 align-items-center">
                    <div class="col-md-3">
                    <div class="navbar-nav align-items-center">
                <div class="nav-item d-flex align-items-center mt-4 mr-4" >
                  <i class="bx bx-search fs-4 lh-0"></i>
                  <input
                    type="text"
                    class="form-control border-0 shadow-none"
                    placeholder="Search..."
                    aria-label="Search..."
                  />
                </div>
              </div>
                      <!-- <label class="form-label" for="selectTypeOpt">Type</label>
                      <select id="selectTypeOpt" class="form-select color-dropdown">
                        <option value="bg-primary" selected>Primary</option>
                        <option value="bg-secondary">Secondary</option>
                        <option value="bg-success">Success</option>
                        <option value="bg-danger">Danger</option>
                        <option value="bg-warning">Warning</option>
                        <option value="bg-info">Info</option>
                        <option value="bg-dark">Dark</option>
                      </select> -->
                    </div>
                    <!-- <div class="col-md-3">
                      <label class="form-label" for="selectPlacement">Placement</label>
                      <select class="form-select placement-dropdown" id="selectPlacement">
                        <option value="top-0 start-0">Top left</option>
                        <option value="top-0 start-50 translate-middle-x">Top center</option>
                        <option value="top-0 end-0">Top right</option>
                        <option value="top-50 start-0 translate-middle-y">Middle left</option>
                        <option value="top-50 start-50 translate-middle">Middle center</option>
                        <option value="top-50 end-0 translate-middle-y">Middle right</option>
                        <option value="bottom-0 start-0">Bottom left</option>
                        <option value="bottom-0 start-50 translate-middle-x">Bottom center</option>
                        <option value="bottom-0 end-0">Bottom right</option>
                      </select>
                    </div> -->
                    <div class="col-md-3">
                      <label class="form-label" for="showToastPlacement">&nbsp;</label>
                      <button id="showToastPlacement" class="btn btn-primary d-block border">Rechercher</button>
                    </div>
                    <div class="col-md-3">
                      <label class="form-label" for="showToastPlacement">&nbsp;</label>
                      <button id="showToastPlacement" class="btn btn-primary d-block border">Filtrer</button>
                    </div>
                    <div class="col-md-3">
                      <label class="form-label" for="showToastPlacement">&nbsp;</label>
                      <a href="add.php"><button id="showToastPlacement" class="btn btn-primary d-block border">Ajouter un contact</button></a>
                    </div>
                  </div>
                </div>
              </div>
              <!--/ Bootstrap Toasts with Placement -->

<!-- Striped Rows -->
<div class="card">
                <h5 class="card-header">Tableau recapitulatif</h5>
                <div class="table-responsive text-nowrap">
                  <table class="table table-striped">
                    <thead>
                      <tr>
                        <th>Identifiant</th>
                        <th>Nom et Prenoms</th>
                        <th>Profession</th>
                        <th>Telephone</th>
                        <th>Actions</th>
                      </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                      <?php

                      $contacts = R::findAll('contact');

                        foreach ($contacts as $contact) {
                            
                            echo '<tr>';
                            echo '<td>' . $contact->token . '</td>';
                            echo '<td>' . $contact->firstname. ' ' . $contact->lastname. '</td>';
                            echo '<td>' . $contact->profession. '</td>';
                            echo '<td>' . $contact->phonenumber. '</td>';
                            echo '<td>
                            <button class="btn"><a  href="editcontact.php"><i class="bx bx-edit-alt me-1"></i> Edit</a></button>
                            <button class="btn"><a  href="#"><i class="bx bx-trash me-1"></i> Delete</a></button>
                          </td>';
                            echo '</tr>';
                        }
                      ?>
                    </tbody>
                  </table>
                </div>
              </div>
              <!--/ Striped Rows -->


<?php
include('footer.php');
include('scripts.php');
?>