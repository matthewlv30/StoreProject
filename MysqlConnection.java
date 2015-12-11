/*
 * This sample shows how to list all the names from the EMP table
 *
 * It uses the JDBC THIN driver.  See the same program in the
 * oci8 samples directory to see how to use the other drivers.
 */

// You need to import the java.sql package to use JDBC
import java.sql.*;

class MysqlConnection
{
  public static void main (String args [])
       throws SQLException
  {
	  // Load the Oracle JDBC driver
	    DriverManager.registerDriver(new oracle.jdbc.driver.OracleDriver());

	    // Connect to the database
	    // You must put a database name after the @ sign in the connection URL.
	    // You can use either the fully specified SQL*net syntax or a short cut
	    // syntax as <host>:<port>:<sid>.  The example uses the short cut syntax.
	    Connection conn =
	      DriverManager.getConnection ("jdbc:oracle:thin:hr/hr@oracle1.cise.ufl.edu:1521:orcl",
	                                   "mdlevy", "mD23184900");

	    // Create a Statement
	    Statement stmt = conn.createStatement ();

	    // Select the ENAME column from the EMP table
	    ResultSet rset = stmt.executeQuery ("select * from webuser");

	    // Iterate through the result and print the employee names
	    System.out.println("USERID\tUSERNAME\tADDRESS\t\tUSER_PASSWORD\t\tEMAIL\t\t\tIS_STAFF");
	    System.out.println("------\t---------------\t---------------\t\t---------------\t------------\t------------------");
	    while (rset.next ()) {
	    	int webuserid = rset.getInt("USERID");
	        String username = rset.getString("USERNAME");
	        String address = rset.getString("ADDRESS");
	        String password = rset.getString("USERPASSWORD");
	        String email = rset.getString("EMAIL");
	        int staff = rset.getInt("IS_STAFF");
	        System.out.println(webuserid + "\t" + username +
	                           "\t\t" + address + "\t\t" + password +
	                           "\t\t" + email + "\t" + staff);
	    	
	    }
	    conn.close(); // ** IMPORTANT : Close connections when done **
  }
}
