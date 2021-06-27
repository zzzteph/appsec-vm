package com.shrewdsecurity.bot;
import java.io.IOException;
import org.apache.commons.io.FileUtils;
import java.util.concurrent.TimeUnit;
import java.io.File;
import org.openqa.selenium.WebDriver;
import org.openqa.selenium.WebElement;
import org.openqa.selenium.chrome.ChromeOptions;
import org.openqa.selenium.chrome.ChromeDriver;
import org.openqa.selenium.OutputType;
import org.openqa.selenium.TakesScreenshot;
import org.openqa.selenium.By;
import java.util.Iterator;
import org.json.simple.JSONArray;
import org.json.simple.JSONObject;
import org.json.simple.parser.JSONParser;
import org.json.simple.parser.ParseException;
import java.io.BufferedReader;
import java.io.InputStreamReader;
import java.io.FileReader;
import java.io.IOException;
import java.util.Map;
import java.io.FileReader;
import java.util.Iterator;
import java.util.Random;
import org.apache.commons.cli.*;
public class App {

  public static void main(String[] args) {

    String login = "";
    String password = "";
    String host = "";
    Options options = new Options();

    Option input = new Option("l", "login", true, "login");
    input.setRequired(true);
    options.addOption(input);

    Option output = new Option("p", "password", true, "password");
    output.setRequired(true);
    options.addOption(output);

    CommandLineParser parser = new DefaultParser();
    HelpFormatter formatter = new HelpFormatter();
    try {
      CommandLine cmd;

      cmd = parser.parse(options, args);

      login = cmd.getOptionValue("login");
      password = cmd.getOptionValue("password");

    } catch (Exception e) {
      System.out.println(e.getMessage());
      formatter.printHelp("utility-name", options);

      System.exit(1);
    }

    try {

      host = getIP();

    } catch (Exception e) {

    }

    System.out.println(login);
    System.out.println(password);
    System.out.println(host);
    makeAction("http://" + host, login, password);

    return;
  }

  public static String getIP() {
    Runtime rt = Runtime.getRuntime();
    String ipAddress = "";
    try {
      Process proc = rt.exec("curl 169.254.169.254/latest/meta-data/public-ipv4");

      BufferedReader stdInput = new BufferedReader(new InputStreamReader(proc.getInputStream()));

      BufferedReader stdError = new BufferedReader(new InputStreamReader(proc.getErrorStream()));

      String s = "";
      while ((s = stdInput.readLine()) != null) {
        ipAddress = s;
      }
    } catch (Exception e) {
      System.out.println(e);
    }
    return ipAddress;
  }

  public static boolean makeAction(String server, String login, String password) {
    System.setProperty("webdriver.chrome.driver", "/usr/bin/chromedriver");
    System.setProperty("webdriver.chrome.silentOutput", "true");
    java.util.logging.Logger.getLogger("org.openqa.selenium").setLevel(java.util.logging.Level.OFF);
    ChromeOptions chromeOptions = new ChromeOptions();
    chromeOptions.addArguments("--headless");
    chromeOptions.addArguments("--no-sandbox");
    chromeOptions.addArguments("--disable-popup-blocking");
    chromeOptions.addArguments("--ignore-certificate-errors");
    chromeOptions.addArguments("--window-size=1920,1080");
    chromeOptions.addArguments("--log-level=3");
    chromeOptions.addArguments("--silent");
    WebDriver driver = new ChromeDriver(chromeOptions);

    try {
      driver.manage().timeouts().pageLoadTimeout(10, TimeUnit.SECONDS);
      driver.manage().timeouts().setScriptTimeout(10, TimeUnit.SECONDS);
      driver.manage().timeouts().implicitlyWait(10, TimeUnit.SECONDS);

      System.out.println("Going to " + server + "/auth");
      driver.get(server + "/auth");
      Thread.sleep(3000);
      System.out.println("Log in");
      WebElement loginForm = driver.findElement(By.name("login"));
      WebElement passwordForm = driver.findElement(By.name("password"));
      WebElement submit = driver.findElement(By.name("submit"));
      loginForm.sendKeys(login);
      passwordForm.sendKeys(password);
      submit.click();
      Thread.sleep(3000);
       //navigate to post
      driver.navigate().to(server + "/posts/1");
      Thread.sleep(3000);


		String str = driver.getPageSource();

		int lastIndex = 0;
		int count = 0;
		while(lastIndex != -1){

			lastIndex = str.indexOf("name=\"csrf_\"",lastIndex);
			if(lastIndex != -1){
				count ++;
				lastIndex += "name=\"csrf_\"".length();
			}
		}

		if(count==0)
		{
			System.out.println("No CSRF Token");
			driver.quit();
			return false;
		}

	System.out.println("testfine");
    } catch (Exception e) {
      System.out.println(e);
      driver.quit();
      return false;
    }
    driver.quit();
    return true;

  }

}
