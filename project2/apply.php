<?php include 'header.inc'; ?>
<?php include 'menu.inc'; ?>
<link rel="stylesheet" href="./styles/apply.css">

<div class="container">
      <main>
        <div class="application-form">
          <div class="application-form-detail">
            <h2>Job Application Form</h2>
            <form action="afterfillapply.php" method="post" enctype="multipart/form-data">
              <h4>Contact Information</h4>
              <div class="form-inline">
                <div class="form-group">
                  <label for="fname">First Name *</label>
                  <input
                    type="text"
                    id="fname"
                    name="fname"
                    maxlength="20"
                    required
                  />
                </div>
                <div class="form-group">
                  <label for="lname">Last Name *</label>
                  <input
                    type="text"
                    id="lname"
                    name="lname"
                    maxlength="20"
                    required
                  />
                </div>
              </div>
              <div class="form-group">
                <label for="email">Email *</label>
                <input type="email" id="email" name="email" required />
              </div>
              <div class="form-group">
                <label for="tel">Phone *</label>
                <input
                  type="tel"
                  id="tel"
                  name="tel"
                  minlength="8"
                  maxlength="20"
                  required
                />
              </div>
              <div class="form-group">
                <label for="gender">Gender *</label>
                <select id="gender" name="gender" required>
                  <option value="#">Select Choice</option>
                  <option value="Male">Male</option>
                  <option value="Female">Female</option>
                </select>
              </div>
              <div class="form-group">
                <label for="address">Address *</label>
                <input
                  type="text"
                  id="address"
                  name="address"
                  maxlength="40"
                  required
                />
              </div>
              <div class="form-group">
                <label for="stown">Suburb/Town *</label>
                <input
                  type="text"
                  id="stown"
                  name="stown"
                  maxlength="40"
                  required
                />
              </div>
              <div class="form-group">
                <label for="state">State *</label>
                <select id="state" name="state" required>
                  <option value="#">Select Choice</option>
                  <option value="VIC">VIC</option>
                  <option value="NSW">NSW</option>
                  <option value="QLD">QLD</option>
                  <option value="NT">NT</option>
                  <option value="WA">WA</option>
                  <option value="SA">SA</option>
                  <option value="TAS">TAS</option>
                  <option value="ACT">ACT</option>
                </select>
              </div>
              <br />
              <h4>Position</h4>
              <hr />
              <div class="form-group">
                <label for="jobnumber">Job Reference Number *</label>
                <select id="jobnumber" name="jobnumber" required>
                  <option value="#">Select Choice</option>
                  <option value="PM10">PM10</option>
                  <option value="DE11">DE11</option>
                  <option value="DS12">DS12</option>
                  <option value="FD13">FD13</option>
                </select>
              </div>

              <div class="form-group">
                <label for="cv_image">Upload CV:</label>
                <input type="file" name="cv_image" id="cv_image" accept="image/*" required />
              </div>
              <div class="form-group">
                <label for="skills">Other Skills</label>
                <input type="text" id="skills" name="skills" />
              </div>
              <hr />
              <button type="submit">Submit</button>
            </form>
          </div>
        </div>
        <footer class="footer">
          <p>Copyright © 2025 by Bitbops .All rights reserved.</p>
        </footer>
      </main>
    </div>
  </body>
</html>




