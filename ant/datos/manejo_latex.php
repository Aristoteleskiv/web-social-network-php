<?php


$panelControlLatex = '
        
<div onclick="addTexto(\'[latex]  [/latex]\');" class="div-elm-frml-latex">
[latex]</div><br>

<div onclick="addTexto(\'\\\alpha\');" class="div-elm-frml-latex">
<img src="images/latex/dash/alpha.gif"></div>
<div onclick="addTexto(\'\\\beta\');" class="div-elm-frml-latex">
<img src="images/latex/dash/beta.gif"></div>
<div onclick="addTexto(\'\\\gamma\');" class="div-elm-frml-latex">
<img src="images/latex/dash/gamma.gif"></div>
<div onclick="addTexto(\'\\\delta\');" class="div-elm-frml-latex">
<img src="images/latex/dash/delta.gif"></div>
<div onclick="addTexto(\'\\\epsilon\');" class="div-elm-frml-latex">
<img src="images/latex/dash/epsilon.gif"></div>
<div onclick="addTexto(\'\\\eta\');" class="div-elm-frml-latex">
<img src="images/latex/dash/eta.gif"></div>
<div onclick="addTexto(\'\\\tetha\');" class="div-elm-frml-latex">
<img src="images/latex/dash/tetha.gif"></div>
<div onclick="addTexto(\'\\\kappa\');" class="div-elm-frml-latex">
<img src="images/latex/dash/kappa.gif"></div>
<div onclick="addTexto(\'\\\lambda\');" class="div-elm-frml-latex">
<img src="images/latex/dash/lambda.gif"></div>
<div onclick="addTexto(\'\\\mu\');" class="div-elm-frml-latex">
<img src="images/latex/dash/mu.gif"></div>
<div onclick="addTexto(\'\\\nu\');" class="div-elm-frml-latex">
<img src="images/latex/dash/nu.gif"></div>
<div onclick="addTexto(\'\\\xi\');" class="div-elm-frml-latex">
<img src="images/latex/dash/xi.gif"></div>
<div onclick="addTexto(\'\\\pi\');" class="div-elm-frml-latex">
<img src="images/latex/dash/pi.gif"></div>
<div onclick="addTexto(\'\\\rho\');" class="div-elm-frml-latex">
<img src="images/latex/dash/rho.gif"></div>
<div onclick="addTexto(\'\\\sigma\');" class="div-elm-frml-latex">
<img src="images/latex/dash/sigma.gif"></div>
<div onclick="addTexto(\'\\\tau\');" class="div-elm-frml-latex">
<img src="images/latex/dash/tau.gif"></div>
<div onclick="addTexto(\'\\\phi\');" class="div-elm-frml-latex">
<img src="images/latex/dash/phi.gif"></div>
<div onclick="addTexto(\'\\\varphi\');" class="div-elm-frml-latex">
<img src="images/latex/dash/varphi.gif"></div>
<div onclick="addTexto(\'\\\omega\');" class="div-elm-frml-latex">
<img src="images/latex/dash/omega.gif"></div>
<div onclick="addTexto(\'\\\Delta\');" class="div-elm-frml-latex">
<img src="images/latex/dash/Delta.gif"></div>
<div onclick="addTexto(\'\\\Omega\');" class="div-elm-frml-latex">
<img src="images/latex/dash/Omega.gif"></div><br>

<div onclick="addTexto(\'\\\mathbb{P}\');" class="div-elm-frml-latex">
<img src="images/latex/dash/pMat.gif"></div>
<div onclick="addTexto(\'\\\mathbb{R}\');" class="div-elm-frml-latex">
<img src="images/latex/dash/rMat.gif"></div>
<div onclick="addTexto(\'\\\mathbb{Z}\');" class="div-elm-frml-latex">
<img src="images/latex/dash/zMat.gif"></div>
<div onclick="addTexto(\'\\\mathbb{C}\');" class="div-elm-frml-latex">
<img src="images/latex/dash/cMat.gif"></div>
<div onclick="addTexto(\'\\\mathbb{Q}\');" class="div-elm-frml-latex">
<img src="images/latex/dash/qMat.gif"></div>
<div onclick="addTexto(\'\\\mathbb{I}\');" class="div-elm-frml-latex">
<img src="images/latex/dash/iMat.gif"></div>
<div onclick="addTexto(\'\\\mathbb{N}\');" class="div-elm-frml-latex">
<img src="images/latex/dash/nMat.gif"></div><br>

<div onclick="addTexto(\'\\\leq\');" class="div-elm-frml-latex">
<img src="images/latex/dash/leq.gif"></div>
<div onclick="addTexto(\'\\\geq\');" class="div-elm-frml-latex">
<img src="images/latex/dash/geq.gif"></div>
<div onclick="addTexto(\'\\\neq\');" class="div-elm-frml-latex">
<img src="images/latex/dash/distinto.gif"></div>
<div onclick="addTexto(\'\\\cdot\');" class="div-elm-frml-latex" style="width: 10px;">
<img src="images/latex/dash/punto.gif"></div>
<div onclick="addTexto(\'\\\pm\');" class="div-elm-frml-latex">
<img src="images/latex/dash/mas_menos.gif"></div>
<div onclick="addTexto(\'\\\infty\');" class="div-elm-frml-latex">
<img src="images/latex/dash/inf.gif"></div>
<div onclick="addTexto(\'\\\rightarrow\');" class="div-elm-frml-latex">
<img src="images/latex/dash/flechad.gif"></div>
<div onclick="addTexto(\'\\\leftarrow\');" class="div-elm-frml-latex">
<img src="images/latex/dash/flechai.gif"></div>
<div onclick="addTexto(\'\\\Rightarrow\');" class="div-elm-frml-latex">
<img src="images/latex/dash/entonces.gif"></div>
<div onclick="addTexto(\'\\\Leftrightarrow\');" class="div-elm-frml-latex">
<img src="images/latex/dash/implica.gif"></div><br>


<div onclick="addTexto(\'^{}\');" class="div-elm-frml-latex">
<img src="images/latex/dash/x^a.gif"></div>
<div onclick="addTexto(\'_{}^{}\');" class="div-elm-frml-latex">
<img src="images/latex/dash/x_a^b.gif"></div>
<div onclick="addTexto(\'\\\frac{}{}\');" class="div-elm-frml-latex">
<img src="images/latex/dash/a_div_b.gif"></div>
<div onclick="addTexto(\'\\\sqrt{}\');" class="div-elm-frml-latex">
<img src="images/latex/dash/sqr.gif"></div>
<div onclick="addTexto(\'\\\sqrt[]{}\');" class="div-elm-frml-latex">
<img src="images/latex/dash/sqr_n.gif"></div>
<div onclick="addTexto(\'\\\frac{\\\partial }{\\\partial x}\');" class="div-elm-frml-latex">
<img src="images/latex/dash/parcial.gif"></div>
<div onclick="addTexto(\'\\\frac{d }{d x}\');" class="div-elm-frml-latex">
<img src="images/latex/dash/d_dx.gif"></div>
<div onclick="addTexto(\'\\\int\');" class="div-elm-frml-latex">
<img src="images/latex/dash/int.gif"></div>
<div onclick="addTexto(\'\\\int_{}^{}\');" class="div-elm-frml-latex">
<img src="images/latex/dash/int_ab.gif"></div>
<div onclick="addTexto(\'\\\oint \');" class="div-elm-frml-latex">
<img src="images/latex/dash/int_c.gif"></div>
<div onclick="addTexto(\'\\\sum\');" class="div-elm-frml-latex">
<img src="images/latex/dash/suma.gif"></div>
<div onclick="addTexto(\'\\\sum_{}^{}\');" class="div-elm-frml-latex">
<img src="images/latex/dash/suma_ab.gif"></div>
<div onclick="addTexto(\'\\\lim_{x \\\rightarrow +\\\infty}\');" class="div-elm-frml-latex">
<img src="images/latex/dash/lim.gif"></div><br>

<div onclick="addTexto(\'\\\left( \\\right)\');" class="div-elm-frml-latex">
<img src="images/latex/dash/parent.gif"></div>
<div onclick="addTexto(\'\\\left[ \\\right]\');" class="div-elm-frml-latex">
<img src="images/latex/dash/corch.gif"></div>
<div onclick="addTexto(\'\\\left| \\\right|\');" class="div-elm-frml-latex">
<img src="images/latex/dash/mod.gif"></div><br>

<div onclick="addTexto(\'\\\left\\\{\\\begin{matrix} & \\\\\\\\ & \\\end{matrix}\\\right\');" class="div-elm-frml-latex">
<img src="images/latex/dash/llave.gif"></div>
<div onclick="addTexto(\'\\\begin{vmatrix} & \\\\\\\\ & \\\end{vmatrix}\');" class="div-elm-frml-latex">
<img src="images/latex/dash/det.gif"></div>


';




?>







