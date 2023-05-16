<?php
include('blankpage.php');
?>
<head>
<link rel="stylesheet" type="text/css" href="../lib/assets/css/add.css">

</head>

<div class="form col-xxl">
                  <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                      <h5 class="mb-0">Personal informations</h5>
                      <!-- <small class="text-muted float-end">Default label</small> -->
                    </div>
                    <div class="card-body">
                      <form action="../../api/controller/contacts/add/" method="POST">
                        <div class="mb-3">
                          <label class="form-label" for="basic-default-fullname">First Name</label>
                          <input type="text" class="form-control" id="basic-default-fullname" placeholder="John Doe" name="firstname" />
                        </div>
                        <div class="mb-3">
                          <label class="form-label" for="basic-default-fullname">Last Name</label>
                          <input type="text" class="form-control" id="basic-default-fullname" placeholder="John Doe" name="lastname" />
                        </div>
                        <!-- <div class="mb-3">
                          <label class="form-label" for="basic-default-company">Company</label>
                          <input type="text" class="form-control" id="basic-default-company" placeholder="ACME Inc." />
                        </div> -->
                        <div><br><label class="form-label">Birthday</label></div>
                        <div class="input-group mb-3">
                            <label class="input-group-text" for="inputGroupSelect01">Day</label>
                            <select class="form-select" id="inputGroupSelect01" name="dayofbirth">
                              <option selected></option>
                              <option value="1">1</option>
                              <option value="2">2</option>
                              <option value="3">3</option>
                            </select>
                            <label class="input-group-text" for="inputGroupSelect01" >Month</label>
                            <select class="form-select" id="inputGroupSelect01" name="monthofbirth">
                              <option selected></option>
                              <option value="1">1</option>
                              <option value="2">2</option>
                              <option value="3">3</option>
                            </select>
                            <label class="input-group-text" for="inputGroupSelect01">Year</label>
                            <select class="form-select" id="inputGroupSelect01" name="yearofbirth">
                              <option selected></option>
                              <option value="2022">2022</option>
                              <option value="2021">2021</option>
                              <option value="2020">2020</option>
                            </select>
                          </div>
                        <!-- <div class="mb-3">
                          <label class="form-label" for="basic-default-email">Email</label>
                          <div class="input-group input-group-merge">
                            <input
                              type="text"
                              id="basic-default-email"
                              class="form-control"
                              placeholder="john.doe"
                              aria-label="john.doe"
                              aria-describedby="basic-default-email2"
                            />
                            <span class="input-group-text" id="basic-default-email2">@example.com</span>
                          </div>
                          <div class="form-text">You can use letters, numbers & periods</div>
                        </div> -->
                        <div class="col-md mb-3">
                        <label class="form-label">gender</label><br>
                          <div class="form-check form-check-inline mt-3">
                            <input
                              class="form-check-input"
                              type="radio"
                              name="gender"
                              id="inlineRadio1"
                              value="f"
                            />
                            <label class="form-check-label" for="inlineRadio1">Female</label>
                          </div>
                          <div class="form-check form-check-inline">
                            <input
                              class="form-check-input"
                              type="radio"
                              name="gender"
                              id="inlineRadio2"
                              value="m"
                            />
                            <label class="form-check-label" for="inlineRadio2">Male</label>
                          </div>
                        
                        </div>
                        <div class="mb-3">
                          <label class="form-label" for="basic-default-phone">Phone No</label>
                          <input
                            type="text"
                            id="basic-default-phone"
                            class="form-control phone-mask"
                            placeholder="658 799 8941"
                            name="phonenumber"
                          />
                        </div>
                        <div class="mb-3">
                          <label class="form-label" for="basic-default-phone">Profession</label>
                          <input
                            type="text"
                            id="basic-default-phone"
                            class="form-control phone-mask"
                            placeholder="financial director"
                            name="profession"
                          />
                        </div>

                      <!--   <div class="input-group mb-3">
                        <label class="input-group-text" for="inputGroupSelect01">City</label>
                            <select class="form-select" id="inputGroupSelect01" name="city">
                              <option selected></option>
                              <option value="d39fc6a0">Doualteee</option>
                              <option value="54bd8d9b">YAOUNDE</option>
                              <option value="3">3</option>
                            </select>
                        </div> -->

                        <div class="mb-3">
                          <label class="form-label" for="basic-default-message">Description</label>
                          <textarea
                            id="basic-default-message"
                            class="form-control"
                            placeholder="Hi, Do you have a moment to talk Joe?"
                            name="description"
                          ></textarea>
                        </div>

                        <div class="input-group mb-3">
                        <label class="input-group-text" for="inputGroupSelect01">City</label>
                            <select class="form-select" id="inputGroupSelect01" name="city">
                              <option selected></option>
                              <option value="d39fc6a0">Doualteee</option>
                              <option value="54bd8d9b">YAOUNDE</option>
                              <option value="3">3</option>
                            </select>
                        </div>

                        <button type="submit" class="btn btn-primary">Send</button>
                      </form>
                    </div>
                  </div>
                </div>