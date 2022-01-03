package com.backend.ssti.Controller;

import com.backend.ssti.Service.BlogService;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Controller;
import org.springframework.ui.Model;
import org.springframework.web.bind.annotation.GetMapping;
import org.springframework.web.bind.annotation.PostMapping;
import org.springframework.web.bind.annotation.RequestParam;

@Controller
public class HelloController {

    @Autowired
    private BlogService blogService;

    @GetMapping("/")
    public String main() {
        return "index";
    }

    @PostMapping("/")
    public String index(@RequestParam String name, Model model) {
        if (name == null){
            return "error";
        }
        model.addAttribute("name", name);
        return "index";
    }

    @GetMapping("/reviews")
    public String blog(Model model){
        model.addAttribute("blogs", blogService.findAll());
        return "reviews";
    }

    @PostMapping("/reviews")
    public String blogPost(@RequestParam String name,
                           @RequestParam String message,
                           Model model){
        blogService.save(name, message);
        model.addAttribute("blogs", blogService.findAll());
        return "reviews";
    }

}
