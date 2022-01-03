/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Classes/Class.java to edit this template
 */
package appsec.study.rce.controller;

/**
 *
 * @author steph
 */
import org.springframework.stereotype.Controller;
import org.springframework.ui.Model;
import org.springframework.web.bind.annotation.GetMapping;
import org.springframework.web.bind.annotation.PostMapping;
import org.springframework.web.bind.annotation.RequestParam;
import java.io.BufferedReader;
import java.io.IOException;
import java.io.InputStreamReader;
import java.util.List;

@Controller
public class MainController {

    private static String OS = System.getProperty("os.name").toLowerCase();

    @GetMapping("/")
    public String index() {

        return "index";
    }

    @GetMapping("/admin")
    public String admin(Model model) {

        return "admin";
    }

    @PostMapping("/admin")
    public String admin_ping(@RequestParam(name = "command", required = false) String command, Model model) throws IOException {
        Runtime rt = Runtime.getRuntime();

        StringBuilder output = new StringBuilder();
        String exec = "";
        Process proc = null;
        if (isWindows()) {
            exec = "ping -n 1 " + command;
            proc = rt.exec(new String[]{"cmd.exe", "/c", exec});

        } else {
            exec = "ping -c 1 " + command;
            proc = rt.exec(new String[]{"sh", "-c", exec});
        }

        BufferedReader stdInput = new BufferedReader(new InputStreamReader(proc.getInputStream()));
        BufferedReader stdError = new BufferedReader(new InputStreamReader(proc.getErrorStream()));
        String s;
        while ((s = stdInput.readLine()) != null) {
            output.append(s);
            output.append(System.getProperty("line.separator"));
        }

        while ((s = stdError.readLine()) != null) {
            output.append(s);
            output.append(System.getProperty("line.separator"));
        }

        model.addAttribute("command", command);
        model.addAttribute("exec", exec);
        model.addAttribute("output", output.toString());
        return admin(model);
    }

    public static boolean isWindows() {
        return OS.contains("win");
    }

    public static boolean isMac() {
        return OS.contains("mac");
    }

    public static boolean isUnix() {
        return (OS.contains("nix") || OS.contains("nux") || OS.contains("aix"));
    }

    public static boolean isSolaris() {
        return OS.contains("sunos");
    }

    public static String getOS() {
        if (isWindows()) {
            return "win";
        } else if (isMac()) {
            return "osx";
        } else if (isUnix()) {
            return "uni";
        } else if (isSolaris()) {
            return "sol";
        } else {
            return "err";
        }
    }

}
