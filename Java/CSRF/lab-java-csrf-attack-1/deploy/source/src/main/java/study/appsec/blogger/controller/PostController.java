package study.appsec.blogger.controller;

import study.appsec.blogger.exception.ApplicationException;
import study.appsec.blogger.model.Post;
import study.appsec.blogger.model.User;
import study.appsec.blogger.service.AlertService;
import study.appsec.blogger.service.PostService;
import study.appsec.blogger.service.UserService;
import lombok.RequiredArgsConstructor;
import org.springframework.security.core.annotation.AuthenticationPrincipal;
import org.springframework.stereotype.Controller;
import org.springframework.ui.Model;
import org.springframework.web.bind.annotation.*;
import org.springframework.web.servlet.mvc.support.RedirectAttributes;

import javax.servlet.http.HttpServletRequest;
import java.security.Principal;
import java.util.List;

@Controller
@RequiredArgsConstructor
@RequestMapping("/post")
public class PostController extends BaseController {

    private final UserService userService;
    private final PostService postService;
    private final AlertService alertService;

    @GetMapping("/all")
    public String all(Model model) {
        List<Post> posts = postService.getAll();
        postService.updatePostsRating(posts);
        model.addAttribute("is_crud_allowed", false);
        model.addAttribute("posts", posts);
        return "pages/post/list";
    }

    @GetMapping("/personal")
    public String personal(@AuthenticationPrincipal Principal principal, Model model) {
        ensureAuth(principal);
        User user = userService.getUser(principal);
        model.addAttribute("is_crud_allowed", true);
        model.addAttribute("posts", postService.getUserPosts(user));
        return "pages/post/list";
    }

    @GetMapping("/{id}")
    public String show(@AuthenticationPrincipal Principal principal, Model model, @PathVariable Long id,
                       RedirectAttributes redirectAttributes, HttpServletRequest request) {
        User user = userService.findUser(principal);
        Post post = postService.getById(id);
        postService.updatePostRating(post);

        // --- [ Csrf flag master logic ] ------------------------------------------------------------------------------
        alertService.init(model, redirectAttributes);
        String alertKeyword = "csrf-flag-master";
        if (post.getRating() == UserService.MAX_ALLOWED_USERS_COUNT && !alertService.hasAlert(alertKeyword)) {
            alertService.addSuccessAlert("CSRF_FLAG_MASTER", alertKeyword);
            return redirectCurrent(request);
        }
        // -------------------------------------------------------------------------------------------------------------

        model.addAttribute("is_crud_allowed", postService.isUserCanEditPost(user, post));
        model.addAttribute("post", post);
        model.addAttribute("user_opinion", postService.getUserOpinion(post, user));
        return "pages/post/show";
    }

    @GetMapping("/create")
    public String create(@AuthenticationPrincipal Principal principal, Model model) {
        ensureAuth(principal);
        Post post = new Post();
        model.addAttribute("post", post);
        return "pages/post/edit";
    }

    @GetMapping("/{id}/edit")
    public String edit(@AuthenticationPrincipal Principal principal, @PathVariable Long id, Model model) {
        ensureAuth(principal);
        User user = userService.getUser(principal);
        Post post = postService.getById(id);
        if (!postService.isUserCanEditPost(user, post)) {
            throw new ApplicationException("You cannot edit this post.");
        }
        model.addAttribute("post", post);
        return "pages/post/edit";
    }

    @GetMapping("/{id}/delete")
    public String delete(@AuthenticationPrincipal Principal principal, @PathVariable Long id,
                         RedirectAttributes redirectAttributes, Model model) {
        ensureAuth(principal);
        User user = userService.getUser(principal);
        Post post = postService.getById(id);
        postService.deletePost(post, user);
        alertService.init(model, redirectAttributes);
        alertService.addSuccessAlert("Post has been deleted!");
        return redirect("/post/personal");
    }

    @PostMapping("/update")
    public String handleEdit(@AuthenticationPrincipal Principal principal, @RequestParam Long id,
                             @RequestParam String title, @RequestParam String text,
                             HttpServletRequest request, RedirectAttributes redirectAttributes, Model model) {
        ensureAuth(principal);
        User user = userService.getUser(principal);
        boolean isNew = false;
        Post post;
        if (id == null) {
            post = new Post();
            isNew = true;
        } else {
            post = postService.getById(id);
        }
        alertService.init(model, redirectAttributes);
        try {
            postService.updatePost(post, user, title, text);
        } catch (Exception updateException) {
            alertService.addDangerAlert("Cannot create or update a post with given data!");
            return redirectBack(request, "error=true");
        }
        alertService.addSuccessAlert("Post has been " + (isNew ? "created" : "updated") + "!");
        return redirect("/post/" + post.getId());
    }

}
