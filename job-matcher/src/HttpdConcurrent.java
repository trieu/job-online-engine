
import java.net.Socket;
import java.util.concurrent.*;

/**
 * HttpConcurrent - Httpd Subclass using java.lang.concurrent
 */
public class HttpdConcurrent extends Httpd {


    Executor myThreadPool = Executors.newFixedThreadPool(5);

    public HttpdConcurrent() throws Exception {
        super();
    }

    public static void main(String[] argv) throws Exception {
        System.out.println("DarwinSys JavaWeb Server 0.1 starting...");
        HttpdConcurrent w = new HttpdConcurrent();
        if (argv.length == 2 && argv[0].equals("-p")) {
            w.startServer(Integer.parseInt(argv[1]));
        } else {
            w.startServer(HTTP);
        }
        w.runServer();
    }

    @Override
    public void runServer() throws Exception {
        while (true) {
            final Socket clientSocket = sock.accept();
            myThreadPool.execute(new Runnable() {
                public void run() {
                    new Handler(HttpdConcurrent.this).process(clientSocket);
                }
            });
        }
    }
}
