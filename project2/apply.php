<?php include 'header.inc'; ?>
<?php include 'menu.inc'; ?>
<?php include 'settings.php'; ?>
<link rel="stylesheet" href="./styles/apply.css" />
<div class="container">
  <main>
    <div class="application-form">
      <div class="application-form-detail">
        <h2>Job Application Form</h2>
        <form method="post" action="process_eoi.php">
          <h4>Contact Information</h4>
          <div class="form-inline">
            <div class="form-group">
              <label>First Name *</label>
              <input type="text" id="fname" name="fname" maxlength="20" required />
            </div>
            <div class="form-group">
              <label>Last Name *</label>
              <input type="text" id="lname" name="lname" maxlength="20" required />
            </div>
          </div>
          <div class="form-group">
            <label>Email *</label>
            <input type="email" id="email" name="email" required />
          </div>
          <div class="form-group">
            <label>Phone *</label>
            <input type="tel" id="tel" name="tel" minlength="8" maxlength="20" required />
          </div>
          <div class="form-group">
            <label>Gender *</label>
            <select id="gender" name="gender" required>
              <option value="male">Male</option>
              <option value="female">Female</option>
            </select>
          </div>
          <div class="form-group">
            <label>Address *</label>
            <input type="text" id="address" name="address" maxlength="40" required />
          </div>
          <div class="form-group">
            <label>Suburb/Town *</label>
            <input type="text" id="suburb" name="suburb" maxlength="40" required />
          </div>
          <div class="form-group">
            <label>State *</label>
            <select id="state" name="state" required>
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
            <label>Job reference number *</label>
            <input type="text" id="job_number" name="job_number" minlength="5" maxlength="5" required />
          </div>
          <div class="form-group">
            <label>CV Upload *</label>
            <input type="file" id="resume" name="resume" required />
          </div>
          <div class="form-group">
            <label>Other skills</label>
            <input type="text" id="skills" name="skills" />
          </div>
          <hr />
          <button type="submit">Submit</button>
        </form>
      </div>
    </div>
  </main>
</div>
<?php include 'footer.inc'; ?>