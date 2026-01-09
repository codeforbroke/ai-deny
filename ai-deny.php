<?php
/**
 * Plugin Name:   AI Deny
 * Plugin URI:    https://github.com/codeforbroke/ai-deny
 * Description:   Easily block over 30 of the most common AI user-agents known for crawling websites, keeping unauthorized bots at bay.
 * Author:        Code For Broke, Inc.
 * Author URI:    https://codeforbroke.com/
 * Text Domain:   ai-deny
 * License:       GPL v2 or later
 * License URI:   https://www.gnu.org/licenses/gpl-2.0.html
 * Version:       0.1.1
 *
 * @package     AI_Deny
 */

if (!defined('ABSPATH')) exit;

define( 'AI_DENY_VERSION', '0.1.1' );

class AIDeny {
  private $option_name = 'ai_deny_settings';
  private $ai_bots = [];

  public function __construct() {
    $this->init_ai_bots();
    register_activation_hook(__FILE__, [$this, 'activate_plugin']);
    add_action('admin_menu', [$this, 'add_menu_page']);
    add_action('admin_enqueue_scripts', [$this, 'enqueue_assets']);
    add_filter('robots_txt', [$this, 'modify_robots_txt'], 10, 2);
    add_action('wp_ajax_update_robots_rule', [$this, 'update_robots_rule']);
    add_action('wp_head', function () {
      echo '<meta name="robots" content="noai, noimageai" />';
    }, 1);
  }

  private function init_ai_bots() {
    $this->ai_bots = [
      'ai2bot' => [
        'name' => 'AI2Bot',
        'user_agent' => 'AI2Bot',
        'description' => __( 'AI2Bot is a web crawler operated by the Allen Institute for AI, designed to gather web content for research and to support the development of AI models and tools.', 'ai-deny')
      ],
      'ai2botdolma' => [
        'name' => 'Ai2Bot-Dolma',
        'user_agent' => 'Ai2Bot-Dolma',
        'description' => __('Ai2Bot-Dolma is a web crawler operated by the Allen Institute for AI, specifically designed to collect data for building and enhancing the Dolma dataset, which supports the development of advanced AI research models.', 'ai-deny')
      ],
      'amazonbot' => [
        'name' => 'Amazonbot',
        'user_agent' => 'Amazonbot',
        'description' => __('Amazonbot is Amazon’s web crawler designed to enhance services, including expanding Alexa’s ability to answer customer questions.', 'ai-deny')
      ],
      'anthropicai' => [
        'name' => 'Anthropic AI',
        'user_agent' => 'anthropic-ai',
        'description' => __('Anthropic’s web crawler, known as ClaudeBot, systematically browses publicly available internet data to gather information for training and improving their AI models, such as the Claude series.', 'ai-deny')
      ],
      'applebotextended' => [
        'name' => 'Applebot-Extended',
        'user_agent' => 'Applebot-Extended',
        'description' => __('Applebot-Extended is an extension of Apple’s web crawler, Applebot, designed to give website owners control over how their content is used in training Apple’s AI models.', 'ai-deny')
      ],
      'bytespider' => [
        'name' => 'Bytespider',
        'user_agent' => 'Bytespider',
        'description' => __('Bytespider bot is a web crawler used by Bytedance to index and analyze web content, supporting the enhancement of products like TikTok and other data-driven services.', 'ai-deny')
      ],
      'ccbot' => [
        'name' => 'CCBot',
        'user_agent' => 'CCBot',
        'description' => __('CCBot, operated by Common Crawl, is a web crawler that collects vast amounts of publicly available web data. This data is used to create open datasets that support research, data analysis, and various AI and machine learning applications.', 'ai-deny')
      ],
      'chatgptuser' => [
        'name' => 'ChatGPT-User',
        'user_agent' => 'ChatGPT-User',
        'description' => __('The ChatGPT-User bot is a web crawler used by OpenAI to gather publicly available information from websites, enhancing the responses and capabilities of the ChatGPT model.', 'ai-deny')
      ],
      'claudebot' => [
        'name' => 'ClaudeBot',
        'user_agent' => 'ClaudeBot',
        'description' => __('ClaudeBot is a web crawler managed by Anthropic, designed to collect training data for its Large Language Models (LLMs), which support AI products like Claude.', 'ai-deny')
      ],
      'claudeweb' => [
        'name' => 'Claude Web',
        'user_agent' => 'Claude-Web',
        'description' => __('Claude-Web is a web crawler operated by Anthropic, designed to gather publicly available web data to enhance and refine the capabilities of its AI systems, including the Claude language model.', 'ai-deny')
      ],
      'cohereai' => [
        'name' => 'CohereAI',
        'user_agent' => 'cohere-ai',
        'description' => __('CohereAI Bot is a web crawler operated by Cohere to gather publicly available data from websites, supporting the training and improvement of its language models and AI services.', 'ai-deny')
      ],
      'diffbot' => [
        'name' => 'Diffbot',
        'user_agent' => 'Diffbot',
        'description' => __('Diffbot is an AI-powered web crawler and data extraction tool that automatically collects, structures, and organizes information from websites, enabling businesses and developers to build knowledge graphs and enhance data-driven applications.', 'ai-deny')
      ],
      'facebookbot' => [
        'name' => 'FacebookBot',
        'user_agent' => 'FacebookBot',
        'description' => __('FacebookBot is a web crawler used by Meta to fetch and analyze website content for improving its services, such as Facebook’s social media platform and associated products, including link previews and content indexing.', 'ai-deny')
      ],
      'friendlycrawler' => [
        'name' => 'FriendlyCrawler',
        'user_agent' => 'FriendlyCrawler',
        'description' => __('FriendlyCrawler is a web crawler designed to collect and index web content responsibly, often used to support AI training, data analysis, and search engine optimization while adhering to ethical guidelines.', 'ai-deny')
      ],
      'googleextended' => [
        'name' => 'Google-Extended',
        'user_agent' => 'Google-Extended',
        'description' => __('Google-Extended is a product token enabling web publishers to decide if their sites support improving Gemini Apps and Vertex AI generative APIs. Sites blocking Google-Extended are excluded from Vertex AI grounding but remain unaffected in Google Search inclusion or ranking.', 'ai-deny')
      ],
      'googleother' => [
        'name' => 'GoogleOther',
        'user_agent' => 'GoogleOther',
        'description' => __('The GoogleOther bot is a web crawler used by Google for various tasks beyond search indexing, such as research and development.', 'ai-deny')
      ],
      'googleotherimage' => [
        'name' => 'GoogleOther-Image',
        'user_agent' => 'GoogleOther-Image',
        'description' => __('The GoogleOther-Image bot is a web crawler used by Google to index and analyze images for improving image-related search services.', 'ai-deny')
      ],
      'googleothervideo' => [
        'name' => 'GoogleOther-Video',
        'user_agent' => 'GoogleOther-Video',
        'description' => __('The GoogleOther-Video bot is a specialized web crawler used by Google to index and process video content for enhanced search and discovery.', 'ai-deny')
      ],
      'gptbot' => [
        'name' => 'GPTBot',
        'user_agent' => 'GPTBot',
        'description' => __('GPTBot is OpenAI’s web crawler designed to gather publicly available data from the internet to enhance and train AI models like GPT-4 and GPT-5.', 'ai-deny')
      ],
      'imagesiftbot' => [
        'name' => 'ImagesiftBot',
        'user_agent' => 'ImagesiftBot',
        'description' => __('ImagesiftBot is a web crawler designed to index and analyze images from websites, often used for visual data collection, image categorization, and improving search engine capabilities related to image-based content.', 'ai-deny')
      ],
      'kangaroobot' => [
        'name' => 'Kangaroo Bot',
        'user_agent' => 'Kangaroo Bot',
        'description' => __('Kangaroo Bot is a key part of the Kangaroo LLM project, serving as Australia’s first homegrown AI web crawler. It focuses on collecting high-quality Australian content for the VegeMighty Dataset, creating a comprehensive corpus of Australian English text.', 'ai-deny')
      ],
      'oaisearchbot' => [
        'name' => 'OAI-SearchBot',
        'user_agent' => 'OAI-SearchBot',
        'description' => __('OAI-SearchBot is designed for search purposes, enabling the discovery and display of websites within ChatGPT’s search features. It does not crawl content to train OpenAI’s generative AI foundation models.', 'ai-deny')
      ],
      'omgili' => [
        'name' => 'Omgili',
        'user_agent' => 'Omgili',
        'description' => __('The Omgili bot is a web crawler designed to gather data from forums, message boards, and online discussions, enabling the analysis and indexing of user-generated content.', 'ai-deny')
      ],
      'omgilibot' => [
        'name' => 'Omgilibot',
        'user_agent' => 'Omgilibot',
        'description' => __('Omgilibot is a web crawler focused on collecting data from online forums, discussion boards, and user-generated content platforms to enable detailed analysis and indexing of conversational data.', 'ai-deny')
      ],
      'metaexternalagent' => [
        'name' => 'Meta-ExternalAgent',
        'user_agent' => 'Meta-ExternalAgent',
        'description' => __('Meta-ExternalAgent is a web crawler operated by Meta, designed to access and analyze website content for enhancing Meta’s products and services, including link previews and data aggregation for social media platforms.', 'ai-deny')
      ],
      'perplexitybot' => [
        'name' => 'PerplexityBot',
        'user_agent' => 'PerplexityBot',
        'description' => __('PerplexityBot is a web crawler used by Perplexity.ai to gather and index content from websites, enabling its AI to deliver accurate and context-rich answers to user queries.', 'ai-deny')
      ],
      'petalbot' => [
        'name' => 'PetalBot',
        'user_agent' => 'PetalBot',
        'description' => __('PetalBot is a web crawler operated by Petal Search, designed to index and analyze web content to enhance search engine capabilities and deliver accurate and efficient search results.', 'ai-deny')
      ],
      'scrapy' => [
        'name' => 'Scrapy',
        'user_agent' => 'Scrapy',
        'description' => __('Scrapy bot is an open-source web crawling framework used for extracting data from websites, enabling developers to build scalable and customizable web scrapers efficiently.', 'ai-deny')
      ],
      'turnitinbot' => [
        'name' => 'TurnitinBot',
        'user_agent' => 'turnitinbot',
        'description' => __('TurnitinBot is a web crawler operated by Turnitin to scan and index online content, aiding in plagiarism detection and ensuring academic integrity for its users.', 'ai-deny')
      ],
      'timpibot' => [
        'name' => 'Timpibot',
        'user_agent' => 'Timpibot',
        'description' => __('Timpibot is a web crawler designed to index and analyze web content, supporting the Timpibot network’s decentralized search engine and data processing services.', 'ai-deny')
      ],
      'webzioextended' => [
        'name' => 'Webzio-Extended',
        'user_agent' => 'Webzio-Extended',
        'description' => __('Webzio-Extended is a web crawler that helps collect and analyze data from websites, often used for indexing and improving AI-driven search and content discovery applications.', 'ai-deny')
      ],
      'youbot' => [
        'name' => 'YouBot',
        'user_agent' => 'YouBot',
        'description' => __('YouBot is a web crawler designed to index and analyze web content, often used for enhancing search capabilities and supporting AI-driven tools and applications.', 'ai-deny')
      ]
    ];
  }

  public function activate_plugin() {

    if ( isset($_SERVER['DOCUMENT_ROOT']) && file_exists( esc_url_raw(wp_unslash($_SERVER['DOCUMENT_ROOT'])) . '/robots.txt' ) ) {

      wp_die( esc_html(__('A static robots.txt file exists on your server. Remove the robots.txt file and try activating AI Deny again.', 'ai-deny')));

    }

    $existing_settings = get_option($this->option_name, false);
    
    if ($existing_settings === false) {
      $default_settings = array_fill_keys(array_keys($this->ai_bots), true);
      update_option($this->option_name, $default_settings);
    }
  }

  public function add_menu_page() {
    add_options_page(
      'AI Deny',
      'AI Deny',
      'manage_options',
      'ai-deny',
      [$this, 'render_admin_page']
    );
  }

  public function enqueue_assets($hook) {
    if ('settings_page_ai-deny' !== $hook) {
      return;
    }

    wp_enqueue_style(
      'ai-deny-styles',
      plugins_url('includes/css/style.css', __FILE__), array(), AI_DENY_VERSION, 'All'
    );

    wp_enqueue_script(
      'ai-deny-script',
      plugins_url('includes/js/script.js', __FILE__), ['jquery'], AI_DENY_VERSION, true
    );

    wp_localize_script('ai-deny-script', 'ai_deny', [
      'ajaxUrl' => admin_url('admin-ajax.php'),
      'nonce' => wp_create_nonce('ai_deny_nonce')
    ]);
  }

  public function render_admin_page() {
    $settings = get_option($this->option_name, []);
    ?>
    <div class="ai-deny-header-wrapper">
      <div class="ai-deny-header">
        <h1>AI Deny</h1>
      </div>
    </div>

    <div class="ai-deny-wrapper">
      <div class="ai-deny-box">
        <h2><?php echo esc_html(__('Toggle Bots', 'ai-deny')); ?></h2>
        <p><?php echo esc_html(__('By toggling each agent individually, you can fine-tune which bots are allowed or restricted from accessing your site, keeping it optimized and private for real users.', 'ai-deny')); ?></p>
        <div class="ai-deny-items">
          <?php foreach ($this->ai_bots as $key => $bot): ?>
            <div class="ai-deny-item">
              <div class="ai-deny-item-info">
                <h3><?php echo esc_html($bot['name']); ?></h3>
                <p><?php echo esc_html($bot['description']); ?></p>
              </div>
              <label class="ai-deny-switch">
                <input type="checkbox" 
                  class="ai-deny-toggle" 
                  data-bot="<?php echo esc_attr($key); ?>"
                  <?php checked(isset($settings[$key]) && $settings[$key]); ?>>
                <span class="ai-deny-slider"></span>
              </label>
            </div>
          <?php endforeach; ?>
        </div>
      </div>
    </div>
    <?php
  }

  public function update_robots_rule() {
    check_ajax_referer('ai_deny_nonce', 'nonce');

    if (!current_user_can('manage_options')) {
      wp_die(esc_html(__('Unauthorized', 'ai-deny')));
    }

    $ai_bot = ( isset($_POST['bot']) ? sanitize_text_field(wp_unslash($_POST['bot'])) : '' );
    $enabled = ( isset($_POST['enabled']) && $_POST['enabled'] === 'true' ? true : false );

    if (!array_key_exists($ai_bot, $this->ai_bots)) {
      wp_send_json_error(__('Invalid bot', 'ai-deny'));
    }

    $settings = get_option($this->option_name, []);
    $settings[$ai_bot] = $enabled;
    update_option($this->option_name, $settings);

    wp_send_json_success();
  }

  public function modify_robots_txt($output) {
    $settings = get_option($this->option_name, []);
    $rules = [];

    foreach ($this->ai_bots as $key => $ai_bot) {
      if (!empty($settings[$key])) {
        $rules[] = "User-agent: {$ai_bot['user_agent']}";
        $rules[] = "Disallow: /";
        $rules[] = "";
      }
    }

    return $output . "\n" . '# AI Deny' . "\n" . implode("\n", $rules);
  }
}

add_action('init', function() {
  new AIDeny();
});