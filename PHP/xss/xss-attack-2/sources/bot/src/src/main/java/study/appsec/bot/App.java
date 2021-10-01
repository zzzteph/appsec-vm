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
    String screenshot="";
    Options options = new Options();

    Option LoginInput = new Option("l", "login", true, "login");
    LoginInput.setRequired(true);
    options.addOption(LoginInput);

    Option PasswordInput = new Option("p", "password", true, "password");
    PasswordInput.setRequired(true);
    options.addOption(PasswordInput);

    Option HostInput = new Option("h", "host", true, "host");
    HostInput.setRequired(false);
    options.addOption(HostInput);

    Option ScreenShotInput = new Option("s", "screenshot", true, "screenshot");
    ScreenShotInput.setRequired(false);
    options.addOption(ScreenShotInput);



    CommandLineParser parser = new DefaultParser();
    HelpFormatter formatter = new HelpFormatter();
    try {
      CommandLine cmd;

      cmd = parser.parse(options, args);

      login = cmd.getOptionValue("login");
      password = cmd.getOptionValue("password");
	  host = cmd.getOptionValue("host");
		screenshot = cmd.getOptionValue("screenshot");
    } catch (Exception e) {
      System.out.println(e.getMessage());
      formatter.printHelp("utility-name", options);

      System.exit(1);
    }

    try {
if(host==null)
      host = getIP();

    } catch (Exception e) {
	
    }

    System.out.println(login);
    System.out.println(password);
    System.out.println(host);
    makeAction("http://" + host, login, password,screenshot);

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

	public static void takeScreenshot(WebDriver driver, String screenshot) {

		File src = ((TakesScreenshot) driver).getScreenshotAs(OutputType.FILE);
		try {
			FileUtils.copyFile(src, new File(screenshot));
		} catch (IOException e) {

			e.printStackTrace();
		}
	}



  public static boolean makeAction(String host, String login, String password,String screenshot) {
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

      System.out.println("Going to " + host + "/login");
      driver.get(host + "/login");
      Thread.sleep(5000);
      System.out.println("Log in");
      WebElement loginForm = driver.findElement(By.name("login"));
      WebElement passwordForm = driver.findElement(By.name("password"));
      WebElement submit = driver.findElement(By.name("submit"));
      loginForm.sendKeys(login);
      passwordForm.sendKeys(password);
      submit.click();
      Thread.sleep(5000);
      driver.navigate().to(host + "/latest");
      Thread.sleep(5000);
	
	if(screenshot!=null)
	{
		System.out.println(screenshot);
		takeScreenshot(driver,screenshot);
	}

    } catch (Exception e) {
      System.out.println(e);
      driver.quit();
      return false;
    }
    driver.quit();
    return true;

  }

}
