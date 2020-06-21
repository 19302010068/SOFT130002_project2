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

/* server/status/advisor/index.twig */
class __TwigTemplate_61600070251ef3bfc9754cb0d56b2e83bfcd34e8dc0364eb0883b70b4f06b4e3 extends \Twig\Template
{
    private $source;
    private $macros = [];

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->blocks = [
            'content' => [$this, 'block_content'],
        ];
    }

    protected function doGetParent(array $context)
    {
        // line 1
        return "server/status/base.twig";
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 2
        $context["active"] = "advisor";
        // line 1
        $this->parent = $this->loadTemplate("server/status/base.twig", "server/status/advisor/index.twig", 1);
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 4
    public function block_content($context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 5
        echo "
  ";
        // line 6
        if ( !twig_test_empty(($context["data"] ?? null))) {
            // line 7
            echo "    <a href=\"#openAdvisorInstructions\">";
            echo PhpMyAdmin\Util::getIcon("b_help", _gettext("Instructions"));
            echo "</a>

    <div id=\"statustabs_advisor\"></div>

    <div id=\"advisorInstructionsDialog\" class=\"hide\">
      <p>
        ";
            // line 13
            echo _gettext("The Advisor system can provide recommendations on server variables by analyzing the server status variables.");
            // line 16
            echo "      </p>
      <p>
        ";
            // line 18
            echo _gettext("Do note however that this system provides recommendations based on simple calculations and by rule of thumb which may not necessarily apply to your system.");
            // line 21
            echo "      </p>
      <p>
        ";
            // line 23
            echo _gettext("Prior to changing any of the configuration, be sure to know what you are changing (by reading the documentation) and how to undo the change. Wrong tuning can have a very negative effect on performance.");
            // line 26
            echo "      </p>
      <p>
        ";
            // line 28
            echo _gettext("The best way to tune your system would be to change only one setting at a time, observe or benchmark your database, and undo the change if there was no clearly measurable improvement.");
            // line 31
            echo "      </p>
    </div>

    <div id=\"advisorData\" class=\"hide\">";
            // line 34
            echo twig_escape_filter($this->env, ($context["data"] ?? null), "html", null, true);
            echo "</div>
  ";
        } else {
            // line 36
            echo "    ";
            echo call_user_func_array($this->env->getFilter('error')->getCallable(), [_gettext("Not enough privilege to view the advisor.")]);
            echo "
  ";
        }
        // line 38
        echo "
";
    }

    public function getTemplateName()
    {
        return "server/status/advisor/index.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  104 => 38,  98 => 36,  93 => 34,  88 => 31,  86 => 28,  82 => 26,  80 => 23,  76 => 21,  74 => 18,  70 => 16,  68 => 13,  58 => 7,  56 => 6,  53 => 5,  49 => 4,  44 => 1,  42 => 2,  35 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "server/status/advisor/index.twig", "F:\\wxy\\PhpstormProjects\\project2\\xampp\\phpMyAdmin\\templates\\server\\status\\advisor\\index.twig");
    }
}
