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

/* menu-levels.html.twig */
class __TwigTemplate_5933fcd5dd13376cf490e7e96b9e66b9 extends Template
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
        // line 7
        $macros["menu"] = $this->macros["menu"] = $this;
        // line 8
        echo "
";
        // line 9
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar(twig_call_macro($macros["menu"], "macro_menu_links", [($context["items"] ?? null), ($context["attributes"] ?? null), 0], 9, $context, $this->getSourceContext()));
        echo "

";
        $this->env->getExtension('\Drupal\Core\Template\TwigExtension')
            ->checkDeprecations($context, ["_self", "items", "attributes"]);    }

    // line 11
    public function macro_menu_links($__items__ = null, $__attributes__ = null, $__menu_level__ = null, ...$__varargs__)
    {
        $macros = $this->macros;
        $context = $this->env->mergeGlobals([
            "items" => $__items__,
            "attributes" => $__attributes__,
            "menu_level" => $__menu_level__,
            "varargs" => $__varargs__,
        ]);

        $blocks = [];

        ob_start(function () { return ''; });
        try {
            // line 12
            echo "  <ul";
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, ($context["attributes"] ?? null), "addClass", [["menu", ("menu-level-" . $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, twig_first($this->env, $this->sandbox->ensureToStringAllowed(($context["items"] ?? null), 12, $this->source)), "menu_level", [], "any", false, false, true, 12), 12, $this->source))]], "method", false, false, true, 12), 12, $this->source), "html", null, true);
            echo ">
    ";
            // line 13
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable(($context["items"] ?? null));
            foreach ($context['_seq'] as $context["key"] => $context["item"]) {
                // line 14
                echo "      ";
                if ((twig_first($this->env, $context["key"]) != "#")) {
                    // line 15
                    echo "        ";
                    $context["menu_item_classes"] = ["menu-item", ((twig_get_attribute($this->env, $this->source,                     // line 17
$context["item"], "is_expanded", [], "any", false, false, true, 17)) ? ("menu-item--expanded") : ("")), ((twig_get_attribute($this->env, $this->source,                     // line 18
$context["item"], "is_collapsed", [], "any", false, false, true, 18)) ? ("menu-item--collapsed") : ("")), ((twig_get_attribute($this->env, $this->source,                     // line 19
$context["item"], "in_active_trail", [], "any", false, false, true, 19)) ? ("menu-item--active-trail") : (""))];
                    // line 21
                    echo "
        <li";
                    // line 22
                    echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, $context["item"], "attributes", [], "any", false, false, true, 22), "addClass", [($context["menu_item_classes"] ?? null)], "method", false, false, true, 22), 22, $this->source), "html", null, true);
                    echo ">
          ";
                    // line 23
                    echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->extensions['Drupal\Core\Template\TwigExtension']->getLink($this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, $context["item"], "title", [], "any", false, false, true, 23), 23, $this->source), $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, $context["item"], "url", [], "any", false, false, true, 23), 23, $this->source)), "html", null, true);
                    echo "
          ";
                    // line 24
                    $context["rendered_content"] = $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar($this->extensions['Drupal\Core\Template\TwigExtension']->withoutFilter($this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, $context["item"], "content", [], "any", false, false, true, 24), 24, $this->source), ""));
                    // line 25
                    echo "          ";
                    if (($context["rendered_content"] ?? null)) {
                        // line 26
                        echo "            ";
                        echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["rendered_content"] ?? null), 26, $this->source), "html", null, true);
                        echo "
          ";
                    }
                    // line 28
                    echo "        </li>
      ";
                }
                // line 30
                echo "  ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['key'], $context['item'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 31
            echo "  </ul>
";

            return ('' === $tmp = ob_get_contents()) ? '' : new Markup($tmp, $this->env->getCharset());
        } finally {
            ob_end_clean();
        }
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName()
    {
        return "menu-levels.html.twig";
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
        return array (  117 => 31,  111 => 30,  107 => 28,  101 => 26,  98 => 25,  96 => 24,  92 => 23,  88 => 22,  85 => 21,  83 => 19,  82 => 18,  81 => 17,  79 => 15,  76 => 14,  72 => 13,  67 => 12,  52 => 11,  44 => 9,  41 => 8,  39 => 7,);
    }

    public function getSourceContext()
    {
        return new Source("", "menu-levels.html.twig", "modules/contrib/menu_item_extras/templates/menu-levels.html.twig");
    }
    
    public function checkSecurity()
    {
        static $tags = array("import" => 7, "macro" => 11, "for" => 13, "if" => 14, "set" => 15);
        static $filters = array("escape" => 12, "first" => 12, "render" => 24, "without" => 24);
        static $functions = array("link" => 23);

        try {
            $this->sandbox->checkSecurity(
                ['import', 'macro', 'for', 'if', 'set'],
                ['escape', 'first', 'render', 'without'],
                ['link']
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
