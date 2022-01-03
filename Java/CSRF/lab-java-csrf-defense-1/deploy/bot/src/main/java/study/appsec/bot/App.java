package study.appsec.bot;

import java.io.BufferedReader;
import java.io.File;
import java.io.InputStreamReader;
import java.util.concurrent.TimeUnit;
import org.openqa.selenium.WebDriver;
import org.openqa.selenium.WebElement;
import org.openqa.selenium.chrome.ChromeOptions;
import org.openqa.selenium.chrome.ChromeDriver;
import org.openqa.selenium.By;

public class App {

    static String url = "";
    static String screenshot = "";
    static String auth_url = "";
    static String login = "";
    static String password = "";

    public static void main(String[] args) {

        try {
            String host = getIP();
            if (makeAction("http://" + host, "admin", "1qazxsw23edcvfr45tgbnhy6")
                    && makeAction("http://" + host, "bob", "1qazxsw23edcvfr45tgbnhy6")
                    && makeAction("http://" + host, "mary", "1qazxsw23edcvfr45tgbnhy6")) {
                System.out.println("testfine");
            }

        } catch (Exception e) {

        }

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

            driver.get(server + "/login");
            Thread.sleep(5000);
            WebElement loginForm = driver.findElement(By.name("login"));
            WebElement passwordForm = driver.findElement(By.name("password"));
            WebElement submit = driver.findElement(By.name("submit"));
            loginForm.sendKeys(login);
            passwordForm.sendKeys(password);
            submit.click();
            Thread.sleep(5000);

            //navigate to post
            driver.navigate().to(server + "/post/1");
            String str = driver.getPageSource();
            if (str.indexOf("dislike/1") == -1) {
                System.out.println("Error after login");
                driver.quit();
                return false;
            }

            int lastIndex = 0;
            int count = 0;
            while (lastIndex != -1) {

                lastIndex = str.indexOf("name=\"_csrf\"", lastIndex);
                if (lastIndex != -1) {
                    count++;
                    lastIndex += "name=\"_csrf\"".length();
                }
            }
            if (count != 3) {
                System.out.println("No CSRF Token");
                driver.quit();
                return false;
            }

        } catch (Exception e) {
            driver.quit();
            return false;
        }
        driver.quit();
        return true;

    }

}
