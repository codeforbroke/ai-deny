=== AI Deny ===
Contributors: codeforbroke
Tags: ai, robots.txt, ai crawlers, bots, gptbot
Requires at least: 6.0
Tested up to: 7.1
Stable tag: 0.1.2
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Block 30+ AI crawlers in your robots.txt, including GPTBot, ClaudeBot and CCBot, and choose exactly which bots get in.

== Description ==

AI companies crawl the open web to train their models and power AI search. AI Deny gives you a simple way to say no.

It adds `Disallow` rules for more than 30 known AI user agents to the robots.txt that WordPress already serves. Nothing is blocked until you choose. Block every one of them, or go down the list and pick only the ones you want to keep out. Each crawler comes with a short note on who runs it and what it's for, so you're never guessing.

= What you get =

* **30+ AI crawlers, ready to block.** GPTBot, ChatGPT-User, OAI-SearchBot, ClaudeBot, Google-Extended, Applebot-Extended, CCBot, PerplexityBot, Bytespider, Meta-ExternalAgent and more.
* **A toggle for every bot.** Choose crawler by crawler under Settings → AI Deny.
* **Plain-English descriptions.** See who operates each crawler and what it collects before you decide.
* **Nothing written to your server.** Rules are added through WordPress's own robots.txt filter, so there's no file to manage.
* **Works with "Discourage search engines."** Your AI rules still appear when that setting is on.
* **A `noai, noimageai` meta tag** on every page, for crawlers that look for it.
* **Translation ready.**

= Why block AI crawlers? =

* **Your work, your call.** Decide whether your writing, photos and products end up in someone else's training data.
* **A lighter server load.** Aggressive crawlers can hammer a site with requests, slowing it down for the people you actually built it for.
* **Less bandwidth spent on bots** that send you little or no traffic in return.

= A straight answer about robots.txt =

robots.txt is a request, not a lock. The major AI companies say their crawlers respect it, and that covers most of the traffic you'll see. A bot that chooses to ignore robots.txt won't be stopped by this plugin, or by any robots.txt plugin. If you need that, block it at your host, firewall or CDN.

= Built by Code For Broke =

AI Deny is made and maintained by [Code For Broke](https://codeforbroke.com/), an independent web developer working with marketing teams and small businesses on WordPress and fast, secure websites. Questions and suggestions come straight to me through the [support forum](https://wordpress.org/support/plugin/ai-deny/).

== Installation ==

1. In your dashboard, go to **Plugins → Add New** and search for "AI Deny."
2. Click **Install Now**, then **Activate**.
3. Go to **Settings → AI Deny** and choose which crawlers to block.
4. Visit `yoursite.com/robots.txt` to see your new rules.

AI Deny needs WordPress to generate your robots.txt. If a physical `robots.txt` file sits in your site's root folder, see the FAQ below.

== Frequently Asked Questions ==

= Will this hurt my Google rankings? =

No. Googlebot, the crawler behind Google Search, isn't on the list. Google-Extended only controls whether your content is used for Google's AI products like Gemini; Google says blocking it doesn't affect your Search ranking.

= Will blocking these bots keep me out of AI search results? =

It can. Bots like OAI-SearchBot and PerplexityBot fetch pages so AI search tools can cite them. Block them and those tools are less likely to link to you. If that traffic matters to you, leave those two allowed and block the training crawlers.

= I already have a robots.txt file. Will this work? =

Not while that file is there. When a physical `robots.txt` exists in your site's root folder, your server sends it directly and WordPress never gets the chance to add rules. AI Deny checks for this when you activate it. Copy any custom rules you need into WordPress, then remove the file and let AI Deny handle the rest.

= Does this block AI bots completely? =

It blocks every crawler that respects robots.txt, which includes the major AI companies' published crawlers. A bot that ignores robots.txt has to be blocked at the server or CDN level.

= How do I check that it's working? =

Visit `yoursite.com/robots.txt`. You'll see a `User-agent` and `Disallow: /` pair for each crawler you've blocked.

= A crawler I want to block isn't on the list. =

Let me know in the [support forum](https://wordpress.org/support/plugin/ai-deny/) and I'll look at adding it.

== Changelog ==

= 0.1.2 =
*October 2026*

* Fix: The check for a static robots.txt file now runs on activation.
* Tested with WordPress 7.1.

= 0.1.1 =
*January 9, 2026*

* Fix: Translations were loading too early.
* Fix: AI Deny rules now appear even when "Discourage search engines" is enabled.
* Enhancement: Added development environment support.

= 0.1.0 =
*December 4, 2024*

* Beta release.
