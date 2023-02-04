

import jakarta.servlet.RequestDispatcher;
import jakarta.servlet.ServletException;
import jakarta.servlet.annotation.WebServlet;
import jakarta.servlet.http.HttpServlet;
import jakarta.servlet.http.HttpServletRequest;
import jakarta.servlet.http.HttpServletResponse;

import java.io.BufferedReader;
import java.io.BufferedWriter;
import java.io.File;
import java.io.IOException;
import java.io.InputStream;
import java.io.InputStreamReader;
import java.io.OutputStream;
import java.io.OutputStreamWriter;
import java.io.PrintWriter;
import java.lang.ProcessBuilder.Redirect;
import java.util.Arrays;
import java.util.List;

/**
 * Servlet implementation class AtmServlet
 */
public class AtmServlet extends HttpServlet {
	private static final long serialVersionUID = 1L;
       
    /**
     * @see HttpServlet#HttpServlet()
     */
    public AtmServlet() {
        super();
        // TODO Auto-generated constructor stub
    }

	/**
	 * @see HttpServlet#doGet(HttpServletRequest request, HttpServletResponse response)
	 */
	protected void doGet(HttpServletRequest request, HttpServletResponse response) throws ServletException, IOException {

		System.out.println("1");
		File directory = new File("C:\\Users\\mbrid\\Downloads");
		String path = directory.getAbsolutePath() + "\\ATM.jar";
		ProcessBuilder builder = new ProcessBuilder("java", "-jar", path);
		builder.directory(directory);
		Process process = builder.start();
		InputStream inputStream = process.getInputStream();
		OutputStream outputStream = process.getOutputStream();
		BufferedReader reader = new BufferedReader(new InputStreamReader(inputStream));
		BufferedWriter writer = new BufferedWriter(new OutputStreamWriter(outputStream));
		String line = "";
		int intChar;
		String fullOutput = "";
		System.out.println("2");
//		System.out.println(reader.readLine());
		for (int i=0 ; i<=20 ; i++) {
			intChar = reader.read();
			char trueChar = (char) intChar;
			System.out.println(intChar);
			System.out.println(trueChar);
		    fullOutput += trueChar;
			System.out.println(fullOutput);
		}
		System.out.println("4");
		
//		writer.write("10000\n");
//		writer.flush();
//		fullOutput = "";
//		
//		for (int i=0 ; i<=10 ; i++) {
//			String newLine = reader.readLine();
//		    fullOutput += newLine + "\n";
//		}			
//
//		System.out.println(fullOutput);
		
//		response.getWriter().append("da output is: " + fullOutput);
		response.setContentType("text/html");
		PrintWriter out = response.getWriter();
		out.println("<html><body>");
		out.println("<form action='/atm2/AtmServlet' method='post'>");
		out.println("Your Account Number: <input type='text' name='acc-num'><br>");
		if (request.getAttribute("Invalid") != null) {
		  out.println("<p style=\"color:red\">Invalid account number</p>");
		}
		out.println("<input type='submit' value='Submit'>");
		out.println("</form>");
		out.println("</body></html>");

		System.out.println("9");
	}

	/**
	 * @see HttpServlet#doPost(HttpServletRequest request, HttpServletResponse response)
	 */
	protected void doPost(HttpServletRequest request, HttpServletResponse response) throws ServletException, IOException {
//		 Get the values entered by the user in the form
		String accNum = request.getParameter("acc-num");
		
		File directory = new File("C:\\Users\\mbrid\\Downloads");
		String path = directory.getAbsolutePath() + "\\ATM.jar";
		ProcessBuilder builder = new ProcessBuilder("java", "-jar", path);
		builder.directory(directory);
		Process process = builder.start();
		InputStream inputStream = process.getInputStream();
		OutputStream outputStream = process.getOutputStream();
		BufferedReader reader = new BufferedReader(new InputStreamReader(inputStream));
		BufferedWriter writer = new BufferedWriter(new OutputStreamWriter(outputStream));
		String line = "";
		int intChar;
		String fullOutput = "";
		System.out.println("2");
//		System.out.println(reader.readLine());
		for (int i=0 ; i<=20 ; i++) {
			intChar = reader.read();
			char trueChar = (char) intChar;
			System.out.println(intChar);
			System.out.println(trueChar);
		    fullOutput += trueChar;
			System.out.println(fullOutput);
		}
		System.out.println("4");
		
		writer.write(accNum + "\n");
		writer.flush();
		fullOutput = "";
		
		String atmResponseLine = reader.readLine();
		if(atmResponseLine.startsWith("ERROR: INVALID ACCOUNT NUMBER. TRY AGAIN.")) {
			request.setAttribute("Invalid", true);
			doGet(request, response);
			System.out.println("Invalid");
		}else {
			response.setContentType("text/html");
			PrintWriter out = response.getWriter();
			out.println("<html><body>");
			out.println("<form method='post' action='/atm2/CheckBalanceServlet'>");
			out.println("<input type='hidden' name='acc-num' value='"+accNum+"' />");
			out.println("<input type='submit' name='check-balance' value='Check Balance' />");
			out.println("</form>");
			out.println("<a href='/atm2/AtmServlet'><button>Back</button></a>");
			out.println("</body></html>");
			System.out.println("Valid");
		}
	}

}
