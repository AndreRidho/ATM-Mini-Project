

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

/**
 * Servlet implementation class CheckBalanceServlet
 */
public class CheckBalanceServlet extends HttpServlet {
	private static final long serialVersionUID = 1L;
       
    /**
     * @see HttpServlet#HttpServlet()
     */
    public CheckBalanceServlet() {
        super();
        // TODO Auto-generated constructor stub
    }

	/**
	 * @see HttpServlet#doGet(HttpServletRequest request, HttpServletResponse response)
	 */
	protected void doGet(HttpServletRequest request, HttpServletResponse response) throws ServletException, IOException {
		response.setContentType("text/html");
		PrintWriter out = response.getWriter();
		String balance;
		if(request.getAttribute("error") != null) {
			balance = "An error occurred.";
		}else {
			balance = (String) request.getAttribute("balance");
			if (balance.startsWith("java")) {
				balance = "An error occurred.";
			}			
		}
		out.println("<html><body>");
		out.println("<p>"+balance+"</p><br>");
		if(balance.equals("An error occurred.")) {
			out.println("<form method='get' action='/atm2/AtmServlet'>");
		} else {
			out.println("<form method='post' action='/atm2/AtmServlet'>");
			out.println("<input type='hidden' name='acc-num' value='"+request.getAttribute("acc-num")+"' />");
		}
		out.println("<input type='submit' name='back' value='Back' />");
		out.println("</form>");
		out.println("</body></html>");
	}

	/**
	 * @see HttpServlet#doPost(HttpServletRequest request, HttpServletResponse response)
	 */
	protected void doPost(HttpServletRequest request, HttpServletResponse response) throws ServletException, IOException {
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
//		String line = "";
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
		String accNum = request.getParameter("acc-num");
		System.out.println("a");
		writer.write(accNum + "\n");
		writer.flush();
		

		System.out.println("b");
		
		for (int i=0 ; i<=10 ; i++) {
			System.out.println(i);
			if(reader.readLine().startsWith("java")) {
				request.setAttribute("error", true);
				doGet(request, response);
				return;
			}
		}
		

		System.out.println("c");
		System.out.println("sub-c");
		
		for (int i=0 ; i<=12 ; i++) {
			System.out.println("cfor");
			System.out.print(i);
			reader.read();
		}

		System.out.println("\nd");
		
		writer.write("1\n");
		writer.flush();
		fullOutput = "";
		
		String atmResponseLine = reader.readLine();

		System.out.println("e");
		request.setAttribute("balance", atmResponseLine);
		request.setAttribute("acc-num", accNum);
		doGet(request, response);
	}

}
