import javax.servlet.*;
import javax.servlet.http.*;
import java.io.*;
import java.sql.*;
public class JDBServlet extends HttpServlet {
   
	public void doGet(HttpServletRequest req, HttpServletResponse res) throws ServletException,IOException
	{
		res.setContentType("text/html");
		PrintWriter out = res.getWriter();
		out.println("<html>");
		out.println("<head>");
		out.println("<tittle>Select Page");
		out.println("</tittle>");
		out.println("</head>");
		out.println("<body>");
		out.println("<table>");
		 // Load the Oracle JDBC driver
		try {
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
	    out.println("USERID\tUSERNAME\tADDRESS\t\tUSER_PASSWORD\t\tEMAIL\t\t\tIS_STAFF");
	    out.println("------\t---------------\t---------------\t\t---------------\t------------\t------------------");
	    while (rset.next ()) {
	    	int webuserid = rset.getInt("USERID");
	        String username = rset.getString("USERNAME");
	        String address = rset.getString("ADDRESS");
	        String password = rset.getString("USERPASSWORD");
	        String email = rset.getString("EMAIL");
	        int staff = rset.getInt("IS_STAFF");
	        out.println(webuserid + "\t" + username +
	                           "\t\t" + address + "\t\t" + password +
	                           "\t\t" + email + "\t" + staff);
	    	
	    }
	    conn.close(); // ** IMPORTANT : Close connections when done **
		}
		catch(Exception e){
			
		}
		out.println("</table>");
		out.println("</body>");
		out.println("</html>");
	}
	 
}
