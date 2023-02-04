

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

/**
 * Servlet implementation class CheckValidAccServlet
 */
public class CheckValidAccServlet extends HttpServlet {
	private static final long serialVersionUID = 1L;
       
    /**
     * @see HttpServlet#HttpServlet()
     */
    public CheckValidAccServlet() {
        super();
        // TODO Auto-generated constructor stub
    }

	/**
	 * @see HttpServlet#doGet(HttpServletRequest request, HttpServletResponse response)
	 */
	protected void doGet(HttpServletRequest request, HttpServletResponse response) throws ServletException, IOException {
		// TODO Auto-generated method stub
		response.getWriter().append("Served at: ").append(request.getContextPath());
	}

	/**
	 * @see HttpServlet#doPost(HttpServletRequest request, HttpServletResponse response)
	 */
	protected void doPost(HttpServletRequest request, HttpServletResponse response) throws ServletException, IOException {
		// TODO Auto-generated method stub
		System.out.println("ein");
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
		System.out.println("zwei");
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
		System.out.println("drei");
		writer.write(accNum + "\n");
		writer.flush();
		

		System.out.println("vier");
		fullOutput = "";
		
		for (int i=0 ; i<=10 ; i++) {
			String line = reader.readLine();
			fullOutput += line;
			System.out.println(line);
			if(line.startsWith("java") || line.startsWith("ERROR")) {
				response.getWriter().append("Fail");
				return;
			}
		}
		

		response.getWriter().append("Success");
	}

}
