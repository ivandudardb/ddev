<?php

use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Extension\SandboxExtension;
use Twig\Markup;
use Twig\Sandbox\SecurityError;
use Twig\Sandbox\SecurityNotAllowedTagError;
use Twig\Sandbox\SecurityNotAllowedFilterError;
use Twig\Sandbox\SecurityNotAllowedFunctionError;
use Twig\Source;
use Twig\Template;

/* core/themes/olivero/templates/content/comment.html.twig */
class __TwigTemplate_c90a6ffda8d3db1006ef083f3e134bb5 extends Template
{
    private $source;
    private $macros = [];

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->parent = false;

        $this->blocks = [
        ];
        $this->sandbox = $this->env->getExtension('\Twig\Extension\SandboxExtension');
        $this->checkSecurity();
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 70
        $context["classes"] = ["comment", "js-comment", (( !        // line 73
($context["parent_comment"] ?? null)) ? ("comment--level-1") : ("")), (((        // line 74
($context["status"] ?? null) != "published")) ? (("comment--" . $this->sandbox->ensureToStringAllowed(($context["status"] ?? null), 74, $this->source))) : ("")), ((twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source,         // line 75
($context["comment"] ?? null), "owner", [], "any", false, false, true, 75), "anonymous", [], "any", false, false, true, 75)) ? ("by-anonymous") : ("")), (((        // line 76
($context["author_id"] ?? null) && (($context["author_id"] ?? null) == twig_get_attribute($this->env, $this->source, ($context["commented_entity"] ?? null), "getOwnerId", [], "method", false, false, true, 76)))) ? ((("by-" . $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, ($context["commented_entity"] ?? null), "getEntityTypeId", [], "method", false, false, true, 76), 76, $this->source)) . "-author")) : (""))];
        // line 79
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->extensions['Drupal\Core\Template\TwigExtension']->attachLibrary("olivero/comments"), "html", null, true);
        echo "
<article ";
        // line 80
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, ($context["attributes"] ?? null), "addClass", [($context["classes"] ?? null)], "method", false, false, true, 80), "setAttribute", ["role", "article"], "method", false, false, true, 80), "setAttribute", ["data-drupal-selector", "comment"], "method", false, false, true, 80), 80, $this->source), "html", null, true);
        echo ">
  ";
        // line 86
        echo "  <span class=\"hidden\" data-comment-timestamp=\"";
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["new_indicator_timestamp"] ?? null), 86, $this->source), "html", null, true);
        echo "\"></span>

  ";
        // line 88
        if (($context["submitted"] ?? null)) {
            // line 89
            echo "    <div class=\"comment__picture-wrapper\">
      <div class=\"comment__picture\">
        ";
            // line 91
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["user_picture"] ?? null), 91, $this->source), "html", null, true);
            echo "
      </div>
    </div>
  ";
        }
        // line 95
        echo "  <div class=\"comment__text-wrapper\">
    ";
        // line 96
        if (($context["submitted"] ?? null)) {
            // line 97
            echo "      <footer class=\"comment__meta\">
        <p class=\"comment__author\">";
            // line 98
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["author"] ?? null), 98, $this->source), "html", null, true);
            echo "</p>
        <p class=\"comment__time\">";
            // line 99
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["created"] ?? null), 99, $this->source), "html", null, true);
            echo "</p>
        ";
            // line 105
            echo "        ";
            if (($context["parent"] ?? null)) {
                // line 106
                echo "          <p class=\"visually-hidden\">";
                echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["parent"] ?? null), 106, $this->source), "html", null, true);
                echo "</p>
        ";
            }
            // line 108
            echo "      </footer>
    ";
        }
        // line 110
        echo "    <div";
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, ($context["content_attributes"] ?? null), "addClass", ["comment__content"], "method", false, false, true, 110), 110, $this->source), "html", null, true);
        echo ">
      ";
        // line 111
        if (($context["title"] ?? null)) {
            // line 112
            echo "        ";
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["title_prefix"] ?? null), 112, $this->source), "html", null, true);
            echo "
        <h3";
            // line 113
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["title_attributes"] ?? null), 113, $this->source), "html", null, true);
            echo ">";
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["title"] ?? null), 113, $this->source), "html", null, true);
            echo "</h3>
        ";
            // line 114
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["title_suffix"] ?? null), 114, $this->source), "html", null, true);
            echo "
      ";
        }
        // line 116
        echo "      ";
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["content"] ?? null), 116, $this->source), "html", null, true);
        echo "
    </div>
  </div>
</article>
";
        $this->env->getExtension('\Drupal\Core\Template\TwigExtension')
            ->checkDeprecations($context, ["parent_comment", "status", "comment", "author_id", "commented_entity", "attributes", "new_indicator_timestamp", "submitted", "user_picture", "author", "created", "parent", "content_attributes", "title", "title_prefix", "title_attributes", "title_suffix", "content"]);    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName()
    {
        return "core/themes/olivero/templates/content/comment.html.twig";
    }

    /**
     * @codeCoverageIgnore
     */
    public function isTraitable()
    {
        return false;
    }

    /**
     * @codeCoverageIgnore
     */
    public function getDebugInfo()
    {
        return array (  124 => 116,  119 => 114,  113 => 113,  108 => 112,  106 => 111,  101 => 110,  97 => 108,  91 => 106,  88 => 105,  84 => 99,  80 => 98,  77 => 97,  75 => 96,  72 => 95,  65 => 91,  61 => 89,  59 => 88,  53 => 86,  49 => 80,  45 => 79,  43 => 76,  42 => 75,  41 => 74,  40 => 73,  39 => 70,);
    }

    public function getSourceContext()
    {
        return new Source("", "core/themes/olivero/templates/content/comment.html.twig", "/var/www/html/web/core/themes/olivero/templates/content/comment.html.twig");
    }
    
    public function checkSecurity()
    {
        static $tags = array("set" => 70, "if" => 88);
        static $filters = array("escape" => 79);
        static $functions = array("attach_library" => 79);

        try {
            $this->sandbox->checkSecurity(
                ['set', 'if'],
                ['escape'],
                ['attach_library']
            );
        } catch (SecurityError $e) {
            $e->setSourceContext($this->source);

            if ($e instanceof SecurityNotAllowedTagError && isset($tags[$e->getTagName()])) {
                $e->setTemplateLine($tags[$e->getTagName()]);
            } elseif ($e instanceof SecurityNotAllowedFilterError && isset($filters[$e->getFilterName()])) {
                $e->setTemplateLine($filters[$e->getFilterName()]);
            } elseif ($e instanceof SecurityNotAllowedFunctionError && isset($functions[$e->getFunctionName()])) {
                $e->setTemplateLine($functions[$e->getFunctionName()]);
            }

            throw $e;
        }

    }
}
