package study.appsec.blogger.controller;

import study.appsec.blogger.model.Post;
import study.appsec.blogger.model.User;
import study.appsec.blogger.service.AlertService;
import study.appsec.blogger.service.CommentService;
import study.appsec.blogger.service.PostService;
import study.appsec.blogger.service.UserService;
import lombok.RequiredArgsConstructor;
import org.springframework.security.core.annotation.AuthenticationPrincipal;
import org.springframework.stereotype.Controller;
import org.springframework.ui.Model;
import org.springframework.web.bind.annotation.PathVariable;
import org.springframework.web.bind.annotation.PostMapping;
import org.springframework.web.bind.annotation.RequestMapping;
import org.springframework.web.bind.annotation.RequestParam;
import org.springframework.web.servlet.mvc.support.RedirectAttributes;

import java.security.Principal;

@Controller
@RequiredArgsConstructor
@RequestMapping("/post/{postId}/comment")
public class CommentController extends BaseController {

    private final UserService userService;
    private final PostService postService;
    private final CommentService commentService;
    private final AlertService alertService;

    @PostMapping("/create")
    public String create(@AuthenticationPrincipal Principal principal, Model model,
                         @PathVariable Long postId, @RequestParam String text,
                         RedirectAttributes redirectAttributes) {
        ensureAuth(principal);
        User user = userService.getUser(principal);
        Post post = postService.getById(postId);
        alertService.init(model, redirectAttributes);
        commentService.createComment(post, user, text);
        alertService.addSuccessAlert("Comment has been added!");
        return redirect("/post/" + post.getId());
    }

}
