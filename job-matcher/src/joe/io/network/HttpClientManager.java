package joe.io.network;

import flexjson.JSONDeserializer;
import java.io.IOException;
import java.util.HashMap;
import java.util.Timer;
import java.util.TimerTask;
import org.apache.http.HttpEntity;
import org.apache.http.HttpResponse;
import org.apache.http.client.HttpClient;
import org.apache.http.client.methods.HttpGet;

import org.apache.http.client.methods.HttpPost;
import org.apache.http.impl.client.DefaultHttpClient;
import org.apache.http.util.EntityUtils;

/**
 *
 * @author Trieu Nguyen
 */
public class HttpClientManager {

    protected HttpPost httpPost;
    protected HttpGet httpGet;
    protected HttpClient httpclient;

    public HttpClientManager() {
        super();
        this.httpclient = new DefaultHttpClient();
    }

    public String doHttpPost(String uri) {
        try {
            this.httpPost = new HttpPost(uri);
            HttpResponse response = this.httpclient.execute(httpPost);
            HttpEntity entity = response.getEntity();
            if (entity != null) {
                String text = EntityUtils.toString(entity);
                this.httpPost.abort();
                return text;
            }
        } catch (IOException ex) {
            timer.cancel();
            ex.printStackTrace();
        }
        return "";
    }

    public static String doHttpPostAndGetResponse(String uri) {
        try {
            HttpClient httpclient = new DefaultHttpClient();
            HttpPost httpPost = new HttpPost(uri);
            HttpResponse response = httpclient.execute(httpPost);
            HttpEntity entity = response.getEntity();
            if (entity != null) {
                String text = EntityUtils.toString(entity);
                httpPost.abort();
                return text;
            }
        } catch (IOException ex) {
            timer.cancel();
            ex.printStackTrace();
        }
        return "";
    }

    private static Timer timer = null;
    

    public static void stopTimer() {
        try {
            if(timer != null){
                timer.cancel();
                timer = null;
            }
        } catch (IllegalStateException e) {
            System.out.println("Timer is already stopped! ");
        }

    }

    public static void startTimer() {
        // timer task definition
        TimerTask timerTask = new TimerTask() {

            public void run() {
                String uri = "http://localhost/job-online-website/index.php/master_server/data_service_backup";
                HttpClientManager httpManager = new HttpClientManager();
                String json = httpManager.doHttpPost(uri);
                System.out.println("JSON: " + json);
                JSONDeserializer<HashMap> deserializer = new JSONDeserializer<HashMap>();
                deserializer.use("java.util.HashMap", HashMap.class);
                HashMap<String, String> map = deserializer.deserialize(json);
                System.out.println("map: " + map.get("name"));
            }
        };

        try {
            if(timer == null) {
                // start the timer task
                timer = new Timer("timer", true);
                timer.schedule(timerTask, 0, 1200);
            }
        } catch (IllegalStateException e) {
            e.printStackTrace();            
        }

    }

    public static void main(String[] args) {
    }
}
