<!DOCTYPE html>
<html>
<head>
  <title>Goal Management Dashboard</title>
  <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="styles.css">
  <?php 
    include("Untitled-1b.php"); 
    if(isset($_SESSION['username'])){}
    else{ header("location:login.php"); }
  ?>
</head>
<body>
  <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
      <a class="navbar-brand" href="#">Goal Management System</a>
      <div class="collapse navbar-collapse" id="navbarNav"></div>
    </div>
  </nav>
  <div class="container-fluid">
    <div class="row">
      <!-- Sidebar -->
      <nav id="sidebar" class="col-md-3 bg-light">
        <table class="table table-borderless">
          <tr>
     
            <td><a href="#">Home</a></td>
          </tr>
          <tr>
  
            <td><a href="#">About</a></td>
          </tr>
          <tr>
            <td><a href="#" data-bs-toggle="modal" data-bs-target="#goalParametersModal">Create Goal</a></td>
          </tr>
          <!-- Add Logout link -->
          <tr>
        
            <td><a href="logout.php">Logout</a></td>
          </tr>
        </table>
      </nav>
      <style>
        /* Style the links in the sidebar to have black text */
        #sidebar a {
          color: black;
          text-decoration: none;
          display: block;

          margin-bottom: 10px;
        }
    
        /* Style the links on hover */
        #sidebar a:hover {
          color: #007bff; /* Change to the desired color on hover */
        }
        #sidebar {
      width: 200px; /* Adjust the width as needed */
    }
      </style>
      <!-- Goal Parameters Modal -->
      <div class="modal fade" id="goalParametersModal" tabindex="-1" aria-labelledby="goalParametersModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="goalParametersModalLabel">Goal Parameters</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <form action="Untitled-1b.php" method="post">
                <div className="form-group">
                  <label>Rename Option:</label>
                  <input 
                    type="text" 
                    onChange={handleRenameOptionChange} 
                    name="Rename_Option" required 
                  />
                </div>
                <div className="form-group">
                  <label>Leads Generation:</label>
                  <input 
                    type="number"
                    name="Leads_Generation"  min="1" required
                  />
                </div>
                <div className="form-group">
                  <label>Emails Sent:</label>
                  <input 
                    type="number"
                    name="Emails_Sent" min="1"  required 
                  />
                </div>
                <div className="form-group">
                    <label>Calls Made:</label>
                    <input 
                      type="number"
                      name="Calls_Made"  min="1" required 
                    />
                  </div>
                  <div className="form-group">
                    <label>Progressive Responses:</label>
                    <input 
                      type="number" 
                      name="Progressive_Responses" min="1"  required
                    />
                  </div>
                  <div className="form-group">
                    <label>Meetings Held:</label>
                    <input 
                      type="number"
                      name="Meetings_Held" min="1"  required
                    />
                  </div>
                  <div className="form-group">
                    <label>WhatsApp Sent:</label>
                    <input 
                      type="number"
                      name="WhatsApp_Sent"  min="1" required
                    />
                  </div>
                  <div className="form-group">
                    <label>Sessions Planned:</label>
                    <input 
                      type="number" 
                      name="Sessions_Planned" min="1"  required
                    />
                  </div>
                  <div className="form-group">
                    <label>Sessions Held:</label>
                    <input 
                      type="number"
                      name="Sessions_Held" min="1"  required
                    />
                  </div>
                  <div className="form-group">
                    <label>Centres Planned:</label>
                    <input 
                      type="number"
                      name="Centres_Planned"  min="1" required
                    />
                  </div>
                  
              
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary">Submit</button>
            </div>
            </form>
          </div>
        </div>
      </div>

      <!-- Main Content Area -->
      <div id="content" class="col-md-9">
        <h1>History of Goals</h1>
        <table class="table"style="width: 115%;" >
          <thead>
            <tr>
              <th>ID Number</th>
              <th>Rename Option</th>
              <th>Leads Generation</th>
              <th>Emails Sent</th>
              <th>Calls Made</th>
              <th>Progressive Responses</th>
              <th>Meetings Held</th>
              <th>WhatsApp Sent</th>
              <th>Sessions Planned</th>
              <th>Sessions Held</th>
              <th>Centres Planned</th>
            </tr>
            <?php while($table = mysqli_fetch_object($results)){ ?>
            <tr>
              <th>#<?php echo $table->ID_Number; ?></th>
              <th><?php echo $table->Rename_Option; ?></th>
              <th><?php echo $table->Leads_Generation; ?></th>
              <th><?php echo $table->Emails_Sent; ?></th>
              <th><?php echo $table->Calls_Made; ?></th>
              <th><?php echo $table->Progressive_Responses; ?></th>
              <th><?php echo $table->Meetings_Held; ?></th>
              <th><?php echo $table->WhatsApp_Sent; ?></th>
              <th><?php echo $table->Sessions_Planned; ?></th>
              <th><?php echo $table->Sessions_Held; ?></th>
              <th><?php echo $table->Centres_Planned; ?></th>
            </tr>
            <?php } ?>
          </thead>
          <tbody>
            <!-- Add historical data rows here -->
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script>
  
</script>

  
</body>
</html>
