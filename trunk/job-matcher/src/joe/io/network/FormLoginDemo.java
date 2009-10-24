/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
package joe.io.network;

import java.io.IOException;
import java.util.ArrayList;
import java.util.List;
import java.util.logging.Level;
import java.util.logging.Logger;
import joe.parser.ParseUserAccountTest;
import org.apache.http.Header;
import org.apache.http.HttpEntity;
import org.apache.http.HttpResponse;
import org.apache.http.HttpStatus;
import org.apache.http.NameValuePair;
import org.apache.http.client.ClientProtocolException;
import org.apache.http.client.entity.UrlEncodedFormEntity;
import org.apache.http.client.methods.HttpGet;
import org.apache.http.client.methods.HttpPost;
import org.apache.http.cookie.Cookie;
import org.apache.http.impl.client.DefaultHttpClient;
import org.apache.http.message.BasicNameValuePair;
import org.apache.http.protocol.HTTP;
import org.apache.http.util.EntityUtils;

/**
 * A example that demonstrates how HttpClient APIs can be used to perform
 * form-based logon.
 */
public class FormLoginDemo {

    public static void main(String[] args) throws Exception {

        DefaultHttpClient httpclient = new DefaultHttpClient();

        HttpGet httpget = new HttpGet("http://drdvn.com/admin/Default.aspx");

        HttpResponse response = httpclient.execute(httpget);
        HttpEntity entity = response.getEntity();

        System.out.println("Login form get: " + response.getStatusLine());

        if (entity != null) {
            //System.out.println(EntityUtils.toString(entity));
            entity.consumeContent();
        }
        System.out.println("Initial set of cookies:");
        List<Cookie> cookies = httpclient.getCookieStore().getCookies();
        if (cookies.isEmpty()) {
            System.out.println("None");
        } else {
            for (int i = 0; i < cookies.size(); i++) {
                System.out.println("- " + cookies.get(i).toString());
            }
        }

        /*
         *  do post to login form ---------------------------------------------
         */
        HttpPost httpost = new HttpPost("http://drdvn.com/admin/Default.aspx");

        List<NameValuePair> nvps = new ArrayList<NameValuePair>();
        nvps.add(new BasicNameValuePair("Login1$LoginButton", "Log In"));
        nvps.add(new BasicNameValuePair("Login1$UserName", "quocthanh"));
        nvps.add(new BasicNameValuePair("Login1$Password", "123456"));

        nvps.add(new BasicNameValuePair("__EVENTARGUMENT", ""));
        nvps.add(new BasicNameValuePair("__EVENTTARGET", ""));
        nvps.add(new BasicNameValuePair("__LASTFOCUS", ""));

        nvps.add(new BasicNameValuePair("__VIEWSTATE", "/wEPDwUKMTgwMjU4NzMxNWQYAQUeX19Db250cm9sc1JlcXVpcmVQb3N0QmFja0tleV9fFgEFF0xvZ2luMSRMb2dpbkltYWdlQnV0dG9upqjHP/tUCY4mZ8KO2OcrcwJzm08="));
        nvps.add(new BasicNameValuePair("__EVENTVALIDATION", "/wEWBAKSweaFCAKUvNa1DwL666vYDAKnz4ybCBdYFwaFU24ti+wNqcVx258DUoWt"));


        httpost.setEntity(new UrlEncodedFormEntity(nvps, HTTP.UTF_8));

        response = httpclient.execute(httpost);
        entity = response.getEntity();

        System.out.println("Login form get: " + response.getStatusLine());
        if (entity != null) {
            System.out.println(EntityUtils.toString(entity));
            entity.consumeContent();
        }

        System.out.println("Post logon cookies:");
        cookies = httpclient.getCookieStore().getCookies();
        if (cookies.isEmpty()) {
            System.out.println("None");
        } else {
            for (int i = 0; i < cookies.size(); i++) {
                System.out.println("- " + cookies.get(i).getValue());
            }
        }

        // Usually a successful form-based login results in a redicrect to
        // another url
        int statuscode = response.getStatusLine().getStatusCode();
        if ((statuscode == HttpStatus.SC_MOVED_TEMPORARILY) ||
                (statuscode == HttpStatus.SC_MOVED_PERMANENTLY) ||
                (statuscode == HttpStatus.SC_SEE_OTHER) ||
                (statuscode == HttpStatus.SC_TEMPORARY_REDIRECT)) {
            Header header = response.getHeaders("location")[0];
            if (header != null) {
                String newuri = header.getValue();
                if ((newuri == null) || (newuri.equals(""))) {
                    newuri = "/";
                }
                System.out.println("Redirect target: " + newuri);
                ParseUserAccountTest parser = new ParseUserAccountTest();
                callUrlByGET("http://drdvn.com/admin/TblStudentListAction.aspx", httpclient, parser);
                callUrlByPOST("http://drdvn.com/admin/TblStudentListAction.aspx", httpclient, parser);

            } else {
                System.out.println("Invalid redirect");
                System.exit(1);
            }
        }

        // When HttpClient instance is no longer needed,
        // shut down the connection manager to ensure
        // immediate deallocation of all system resources
        httpclient.getConnectionManager().shutdown();
    }

    static void callUrlByGET(String uri, DefaultHttpClient httpClient, ParseUserAccountTest parser) {
        HttpGet redirect = new HttpGet(uri);
        HttpResponse response;
        try {
            response = httpClient.execute(redirect);
            HttpEntity entity = response.getEntity();
            if (entity != null) {
                //System.out.println(EntityUtils.toString(entity));                
                parser.parseHTMLStream(EntityUtils.toByteArray(entity));
                entity.consumeContent();
            }
        } catch (Exception ex) {
            Logger.getLogger(FormLoginDemo.class.getName()).log(Level.SEVERE, null, ex);
        }
    }

    static void callUrlByPOST(String uri, DefaultHttpClient httpClient, ParseUserAccountTest parser) {
        HttpPost redirect = new HttpPost(uri);
        HttpResponse response;
        try {
            List<NameValuePair> nvps = new ArrayList<NameValuePair>();
            nvps.add(new BasicNameValuePair("__EVENTARGUMENT", "Page$2"));
            nvps.add(new BasicNameValuePair("__EVENTTARGET", "ctl00$ContentPlaceHolder1$StudentList"));
            nvps.add(new BasicNameValuePair("__VIEWSTATEENCRYPTED", ""));
            nvps.add(new BasicNameValuePair("__EVENTVALIDATION", parser.getAsp_net__EVENTVALIDATION()));
            nvps.add(new BasicNameValuePair("__VIEWSTATE", parser.getAsp_net__VIEWSTATE()));
            redirect.setEntity(new UrlEncodedFormEntity(nvps, HTTP.UTF_8));

            response = httpClient.execute(redirect);
            HttpEntity entity = response.getEntity();
            if (entity != null) {
                //System.out.println(EntityUtils.toString(entity));                
                parser.parseHTMLStream(EntityUtils.toByteArray(entity));
                entity.consumeContent();
            }
        } catch (Exception ex) {
            Logger.getLogger(FormLoginDemo.class.getName()).log(Level.SEVERE, null, ex);
        }
    }
}
