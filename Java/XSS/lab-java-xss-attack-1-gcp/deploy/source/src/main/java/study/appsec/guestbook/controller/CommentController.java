package study.appsec.guestbook.controller;

import study.appsec.guestbook.model.Comment;
import study.appsec.guestbook.service.Storage;
import lombok.RequiredArgsConstructor;
import org.springframework.stereotype.Controller;
import org.springframework.web.bind.annotation.PostMapping;
import org.springframework.web.bind.annotation.RequestParam;

@Controller
@RequiredArgsConstructor
public class CommentController extends BaseController {

    private final Storage storage;
	public String firewall(String str)
	{
		
		if(str!=null && !str.isEmpty())
		{
			str=str.toLowerCase();
			str=str.replaceAll("<a","");
			str=str.replaceAll("<abbr","");
			str=str.replaceAll("<acronym","");
			str=str.replaceAll("<address","");
			str=str.replaceAll("<applet","");
			str=str.replaceAll("<area","");
			str=str.replaceAll("<article","");
			str=str.replaceAll("<aside","");
			str=str.replaceAll("<audio","");
			str=str.replaceAll("<b","");
			str=str.replaceAll("<base","");
			str=str.replaceAll("<basefont","");
			str=str.replaceAll("<bdi","");
			str=str.replaceAll("<bdo","");
			str=str.replaceAll("<big","");
			str=str.replaceAll("<blockquote","");
			str=str.replaceAll("<body","");
			str=str.replaceAll("<br","");
			str=str.replaceAll("<button","");
			str=str.replaceAll("<canvas","");
			str=str.replaceAll("<caption","");
			str=str.replaceAll("<center","");
			str=str.replaceAll("<cite","");
			str=str.replaceAll("<code","");
			str=str.replaceAll("<col","");
			str=str.replaceAll("<colgroup","");
			str=str.replaceAll("<data","");
			str=str.replaceAll("<datalist","");
			str=str.replaceAll("<dd","");
			str=str.replaceAll("<del","");
			str=str.replaceAll("<details","");
			str=str.replaceAll("<dfn","");
			str=str.replaceAll("<dialog","");
			str=str.replaceAll("<dir","");
			str=str.replaceAll("<div","");
			str=str.replaceAll("<dl","");
			str=str.replaceAll("<dt","");
			str=str.replaceAll("<em","");
			str=str.replaceAll("<embed","");
			str=str.replaceAll("<fieldset","");
			str=str.replaceAll("<figcaption","");
			str=str.replaceAll("<figure","");
			str=str.replaceAll("<font","");
			str=str.replaceAll("<footer","");
			str=str.replaceAll("<form","");
			str=str.replaceAll("<frame","");
			str=str.replaceAll("<frameset","");
			str=str.replaceAll("<head","");
			str=str.replaceAll("<header","");
			str=str.replaceAll("<hr","");
			str=str.replaceAll("<html","");
			str=str.replaceAll("<i","");
			str=str.replaceAll("<iframe","");
			str=str.replaceAll("<img","");
			str=str.replaceAll("<input","");
			str=str.replaceAll("<ins","");
			str=str.replaceAll("<kbd","");
			str=str.replaceAll("<label","");
			str=str.replaceAll("<legend","");
			str=str.replaceAll("<li","");
			str=str.replaceAll("<link","");
			str=str.replaceAll("<main","");
			str=str.replaceAll("<map","");
			str=str.replaceAll("<mark","");
			str=str.replaceAll("<meta","");
			str=str.replaceAll("<meter","");
			str=str.replaceAll("<nav","");
			str=str.replaceAll("<noframes","");
			str=str.replaceAll("<noscript","");
			str=str.replaceAll("<object","");
			str=str.replaceAll("<ol","");
			str=str.replaceAll("<optgroup","");
			str=str.replaceAll("<option","");
			str=str.replaceAll("<output","");
			str=str.replaceAll("<p","");
			str=str.replaceAll("<param","");
			str=str.replaceAll("<picture","");
			str=str.replaceAll("<pre","");
			str=str.replaceAll("<progress","");
			str=str.replaceAll("<q","");
			str=str.replaceAll("<rp","");
			str=str.replaceAll("<rt","");
			str=str.replaceAll("<ruby","");
			str=str.replaceAll("<s","");
			str=str.replaceAll("<samp","");
			str=str.replaceAll("<script","");
			str=str.replaceAll("<section","");
			str=str.replaceAll("<select","");
			str=str.replaceAll("<small","");
			str=str.replaceAll("<source","");
			str=str.replaceAll("<span","");
			str=str.replaceAll("<strike","");
			str=str.replaceAll("<strong","");
			str=str.replaceAll("<style","");
			str=str.replaceAll("<sub","");
			str=str.replaceAll("<summary","");
			str=str.replaceAll("<sup","");
			str=str.replaceAll("<svg","");
			str=str.replaceAll("<table","");
			str=str.replaceAll("<tbody","");
			str=str.replaceAll("<td","");
			str=str.replaceAll("<templat","");
			str=str.replaceAll("<textarea","");
			str=str.replaceAll("<tfoot","");
			str=str.replaceAll("<th","");
			str=str.replaceAll("<thead","");
			str=str.replaceAll("<time","");
			str=str.replaceAll("<title","");
			str=str.replaceAll("<tr","");
			str=str.replaceAll("<track","");
			str=str.replaceAll("<tt","");
			str=str.replaceAll("<u","");
			str=str.replaceAll("<ul","");
			str=str.replaceAll("<var","");
			str=str.replaceAll("<video","");
			str=str.replaceAll("<wbr","");

			
			
			
		}
		
		return str;
		
	}




    @PostMapping("/comment")
    public String index(@RequestParam String name, @RequestParam String message) {
		//name=firewall(name);
		//message=firewall(message);
        storage.add(new Comment(name, message));
        return redirect("/home");
    }

}
