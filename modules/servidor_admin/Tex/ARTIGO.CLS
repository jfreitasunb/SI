%%
%% This is file `artigo.cls',
%% generated with the docstrip utility.
%%
%% The original source files were:
%%
%% classes.dtx  (with options: `artigo')
%% 
%% This is a generated file.
%% 
%% Copyright 1993 1994 1995 1996 1997
%% The LaTeX3 Project and any individual authors listed elsewhere
%% in this file.
%% 
%% For further copyright information, and conditions for modification
%% and distribution, see the file legal.txt, and any other copyright
%% notices in this file.
%% 
%% This file is part of the LaTeX2e system.
%% ----------------------------------------
%%   This system is distributed in the hope that it will be useful,
%%   but WITHOUT ANY WARRANTY; without even the implied warranty of
%%   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
%% 
%%   For error reports concerning UNCHANGED versions of this file no
%%   more than one year old, see bugs.txt.
%% 
%%   Please do not request updates from us directly.  Primary
%%   distribution is through the CTAN archives.
%% 
%% 
%% IMPORTANT COPYRIGHT NOTICE:
%% 
%% You are NOT ALLOWED to distribute this file alone.
%% 
%% You are allowed to distribute this file under the condition that it
%% is distributed together with all the files listed in manifest.txt.
%% 
%% If you receive only some of these files from someone, complain!
%% 
%% 
%% Permission is granted to copy this file to another file with a
%% clearly different name and to customize the declarations in that
%% copy to serve the needs of your installation, provided that you
%% comply with the conditions in the file legal.txt.
%% 
%% However, NO PERMISSION is granted to generate or to distribute a
%% modified version of this file under its original name.
%% 
%% You are NOT ALLOWED to change this file.
%% 
%% 
%% MODIFICATION ADVICE:
%% 
%% If you want to customize this file, it is best to make a copy of
%% the source file(s) from which it was produced.  Use a different
%% name for your copy(ies) and modify the copy(ies); this will ensure
%% that your modifications do not get overwritten when you install a
%% new release of the standard system.  You should also ensure that
%% your modified source file does not generate any modified file with
%% the same name as a standard file.
%% 
%% You can then easily distribute your modifications by distributing
%% the modified and renamed copy of the source file, taking care to
%% observe the conditions in legal.txt; this will ensure that other
%% users can safely use your modifications.
%% 
%% You will also need to produce your own, suitably named, .ins file to
%% control the generation of files from your source file; this file
%% should contain your own preambles for the files it generates, not
%% those in the standard .ins files.
%% 
%% The names of the source files used are shown above.
%% 
%% 
%% 
%% \CharacterTable
%%  {Upper-case    \A\B\C\D\E\F\G\H\I\J\K\L\M\N\O\P\Q\R\S\T\U\V\W\X\Y\Z
%%   Lower-case    \a\b\c\d\e\f\g\h\i\j\k\l\m\n\o\p\q\r\s\t\u\v\w\x\y\z
%%   Digits        \0\1\2\3\4\5\6\7\8\9
%%   Exclamation   \!     Double quote  \"     Hash (number) \#
%%   Dollar        \$     Percent       \%     Ampersand     \&
%%   Acute accent  \'     Left paren    \(     Right paren   \)
%%   Asterisk      \*     Plus          \+     Comma         \,
%%   Minus         \-     Point         \.     Solidus       \/
%%   Colon         \:     Semicolon     \;     Less than     \<
%%   Equals        \=     Greater than  \>     Question mark \?
%%   Commercial at \@     Left bracket  \[     Backslash     \\
%%   Right bracket \]     Circumflex    \^     Underscore    \_
%%   Grave accent  \`     Left brace    \{     Vertical bar  \|
%%   Right brace   \}     Tilde         \~}
\NeedsTeXFormat{LaTeX2e}[1995/12/01]
\ProvidesClass{artigo}
              [1997/10/10 v1.3x
 Standard LaTeX document class]
\newcommand\@ptsize{}
\newif\if@restonecol
\newif\if@titlepage
\@titlepagefalse
\if@compatibility\else
\DeclareOption{a4paper}
   {\setlength\paperheight {297mm}%
    \setlength\paperwidth  {210mm}}
\DeclareOption{a5paper}
   {\setlength\paperheight {210mm}%
    \setlength\paperwidth  {148mm}}
\DeclareOption{b5paper}
   {\setlength\paperheight {250mm}%
    \setlength\paperwidth  {176mm}}
\DeclareOption{letterpaper}
   {\setlength\paperheight {11in}%
    \setlength\paperwidth  {8.5in}}
\DeclareOption{legalpaper}
   {\setlength\paperheight {14in}%
    \setlength\paperwidth  {8.5in}}
\DeclareOption{executivepaper}
   {\setlength\paperheight {10.5in}%
    \setlength\paperwidth  {7.25in}}
\DeclareOption{landscape}
   {\setlength\@tempdima   {\paperheight}%
    \setlength\paperheight {\paperwidth}%
    \setlength\paperwidth  {\@tempdima}}
\fi
\if@compatibility
  \renewcommand\@ptsize{0}
\else

\DeclareSymbolFont{AMSb}{U}{msb}{m}{n}
\DeclareSymbolFontAlphabet{\mathbb}{AMSb}
\def\Bbb{\mathbb}
\DeclareOption{10pt}{\renewcommand\@ptsize{0}}
\fi
\DeclareOption{11pt}{\renewcommand\@ptsize{1}}
\DeclareOption{12pt}{\renewcommand\@ptsize{2}}
\if@compatibility\else
\DeclareOption{oneside}{\@twosidefalse \@mparswitchfalse}
\fi
\DeclareOption{twoside}{\@twosidetrue  \@mparswitchtrue}
\DeclareOption{draft}{\setlength\overfullrule{5pt}}
\if@compatibility\else
\DeclareOption{final}{\setlength\overfullrule{0pt}}
\fi
\DeclareOption{titlepage}{\@titlepagetrue}
\if@compatibility\else
\DeclareOption{notitlepage}{\@titlepagefalse}
\fi
\if@compatibility\else
\DeclareOption{onecolumn}{\@twocolumnfalse}
\fi
\DeclareOption{twocolumn}{\@twocolumntrue}
\DeclareOption{leqno}{\input{leqno.clo}}
\DeclareOption{fleqn}{\input{fleqn.clo}}
\DeclareOption{openbib}{%
  \AtEndOfPackage{%
   \renewcommand\@openbib@code{%
      \advance\leftmargin\bibindent
      \itemindent -\bibindent
      \listparindent \itemindent
      \parsep \z@
      }%
   \renewcommand\newblock{\par}}%
}
\ExecuteOptions{letterpaper,10pt,oneside,onecolumn,final}
\ProcessOptions
\input{size1\@ptsize.clo}
\setlength\lineskip{1\p@}
\setlength\normallineskip{1\p@}
\renewcommand\baselinestretch{}
\setlength\parskip{0\p@ \@plus \p@}
\@lowpenalty   51
\@medpenalty  151
\@highpenalty 301
\setcounter{topnumber}{2}
\renewcommand\topfraction{.7}
\setcounter{bottomnumber}{1}
\renewcommand\bottomfraction{.3}
\setcounter{totalnumber}{3}
\renewcommand\textfraction{.2}
\renewcommand\floatpagefraction{.5}
\setcounter{dbltopnumber}{2}
\renewcommand\dbltopfraction{.7}
\renewcommand\dblfloatpagefraction{.5}
\if@twoside
  \def\ps@headings{%
      \let\@oddfoot\@empty\let\@evenfoot\@empty
      \def\@evenhead{\thepage\hfil\slshape\leftmark}%
      \def\@oddhead{{\slshape\rightmark}\hfil\thepage}%
      \let\@mkboth\markboth
    \def\sectionmark##1{%
      \markboth {\MakeUppercase{%
        \ifnum \c@secnumdepth >\z@
          \thesection\quad
        \fi
        ##1}}{}}%
    \def\subsectionmark##1{%
      \markright {%
        \ifnum \c@secnumdepth >\@ne
          \thesubsection\quad
        \fi
        ##1}}}
\else
  \def\ps@headings{%
    \let\@oddfoot\@empty
    \def\@oddhead{{\slshape\rightmark}\hfil\thepage}%
    \let\@mkboth\markboth
    \def\sectionmark##1{%
      \markright {\MakeUppercase{%
        \ifnum \c@secnumdepth >\m@ne
          \thesection\quad
        \fi
        ##1}}}}
\fi
\def\ps@myheadings{%
    \let\@oddfoot\@empty\let\@evenfoot\@empty
    \def\@evenhead{\thepage\hfil\slshape\leftmark}%
    \def\@oddhead{{\slshape\rightmark}\hfil\thepage}%
    \let\@mkboth\@gobbletwo
    \let\sectionmark\@gobble
    \let\subsectionmark\@gobble
    }
  \if@titlepage
  \newcommand\maketitle{\begin{titlepage}%
  \let\footnotesize\small
  \let\footnoterule\relax
  \let \footnote \thanks
  \null\vfil
  \vskip 60\p@
  \begin{center}%
    {\LARGE \@title \par}%
    \vskip 3em%
    {\large
     \lineskip .75em%
      \begin{tabular}[t]{c}%
        \@author
      \end{tabular}\par}%
      \vskip 1.5em%
    {\large \@date \par}%       % Set date in \large size.
  \end{center}\par
  \@thanks
  \vfil\null
  \end{titlepage}%
  \setcounter{footnote}{0}%
  \global\let\thanks\relax
  \global\let\maketitle\relax
  \global\let\@thanks\@empty
  \global\let\@author\@empty
  \global\let\@date\@empty
  \global\let\@title\@empty
  \global\let\title\relax
  \global\let\author\relax
  \global\let\date\relax
  \global\let\and\relax
}
\else
\newcommand\maketitle{\par
  \begingroup
    \renewcommand\thefootnote{\@fnsymbol\c@footnote}%
    \def\@makefnmark{\rlap{\@textsuperscript{\normalfont\@thefnmark}}}%
    \long\def\@makefntext##1{\parindent 1em\noindent
            \hb@xt@1.8em{%
                \hss\@textsuperscript{\normalfont\@thefnmark}}##1}%
    \if@twocolumn
      \ifnum \col@number=\@ne
        \@maketitle
      \else
        \twocolumn[\@maketitle]%
      \fi
    \else
      \newpage
      \global\@topnum\z@   % Prevents figures from going at top of page.
      \@maketitle
    \fi
    \thispagestyle{plain}\@thanks
  \endgroup
  \setcounter{footnote}{0}%
  \global\let\thanks\relax
  \global\let\maketitle\relax
  \global\let\@maketitle\relax
  \global\let\@thanks\@empty
  \global\let\@author\@empty
  \global\let\@date\@empty
  \global\let\@title\@empty
  \global\let\title\relax
  \global\let\author\relax
  \global\let\date\relax
  \global\let\and\relax
}
\def\@maketitle{%
  \newpage
  \null
  \vskip 2em%
  \begin{center}%
  \let \footnote \thanks
    {\LARGE \@title \par}%
    \vskip 1.5em%
    {\large
      \lineskip .5em%
      \begin{tabular}[t]{c}%
        \@author
      \end{tabular}\par}%
    \vskip 1em%
    {\large \@date}%
  \end{center}%
  \par
  \vskip 1.5em}
\fi
\setcounter{secnumdepth}{3}
\newcounter {part}
\newcounter {section}
\newcounter {subsection}[section]
\newcounter {subsubsection}[subsection]
\newcounter {paragraph}[subsubsection]
\newcounter {subparagraph}[paragraph]
\renewcommand \thepart {\@Roman\c@part}
\renewcommand \thesection {\@arabic\c@section}
\renewcommand\thesubsection   {\thesection.\@arabic\c@subsection}
\renewcommand\thesubsubsection{\thesubsection .\@arabic\c@subsubsection}
\renewcommand\theparagraph    {\thesubsubsection.\@arabic\c@paragraph}
\renewcommand\thesubparagraph {\theparagraph.\@arabic\c@subparagraph}
\newcommand\part{\par
   \addvspace{4ex}%
   \@afterindentfalse
   \secdef\@part\@spart}

\def\@part[#1]#2{%
    \ifnum \c@secnumdepth >\m@ne
      \refstepcounter{part}%
      \addcontentsline{toc}{part}{\thepart\hspace{1em}#1}%
    \else
      \addcontentsline{toc}{part}{#1}%
    \fi
    {\parindent \z@ \raggedright
     \interlinepenalty \@M
     \normalfont
     \ifnum \c@secnumdepth >\m@ne
       \Large\bfseries \partname~\thepart
       \par\nobreak
     \fi
     \huge \bfseries #2%
     \markboth{}{}\par}%
    \nobreak
    \vskip 3ex
    \@afterheading}
\def\@spart#1{%
    {\parindent \z@ \raggedright
     \interlinepenalty \@M
     \normalfont
     \huge \bfseries #1\par}%
     \nobreak
     \vskip 3ex
     \@afterheading}
\newcommand\section{\@startsection {section}{1}{\z@}%
                                   {-3.5ex \@plus -1ex \@minus -.2ex}%
                                   {2.3ex \@plus.2ex}%
                                   {\normalfont\Large\bfseries}}
\newcommand\subsection{\@startsection{subsection}{2}{\z@}%
                                     {-3.25ex\@plus -1ex \@minus -.2ex}%
                                     {1.5ex \@plus .2ex}%
                                     {\normalfont\large\bfseries}}
\newcommand\subsubsection{\@startsection{subsubsection}{3}{\z@}%
                                     {-3.25ex\@plus -1ex \@minus -.2ex}%
                                     {1.5ex \@plus .2ex}%
                                     {\normalfont\normalsize\bfseries}}
\newcommand\paragraph{\@startsection{paragraph}{4}{\z@}%
                                    {3.25ex \@plus1ex \@minus.2ex}%
                                    {-1em}%
                                    {\normalfont\normalsize\bfseries}}
\newcommand\subparagraph{\@startsection{subparagraph}{5}{\parindent}%
                                       {3.25ex \@plus1ex \@minus .2ex}%
                                       {-1em}%
                                      {\normalfont\normalsize\bfseries}}
\if@twocolumn
  \setlength\leftmargini  {2em}
\else
  \setlength\leftmargini  {2.5em}
\fi
\leftmargin  \leftmargini
\setlength\leftmarginii  {2.2em}
\setlength\leftmarginiii {1.87em}
\setlength\leftmarginiv  {1.7em}
\if@twocolumn
  \setlength\leftmarginv  {.5em}
  \setlength\leftmarginvi {.5em}
\else
  \setlength\leftmarginv  {1em}
  \setlength\leftmarginvi {1em}
\fi
\setlength  \labelsep  {.5em}
\setlength  \labelwidth{\leftmargini}
\addtolength\labelwidth{-\labelsep}
\@beginparpenalty -\@lowpenalty
\@endparpenalty   -\@lowpenalty
\@itempenalty     -\@lowpenalty
\renewcommand\theenumi{\@arabic\c@enumi}
\renewcommand\theenumii{\@alph\c@enumii}
\renewcommand\theenumiii{\@roman\c@enumiii}
\renewcommand\theenumiv{\@Alph\c@enumiv}
\newcommand\labelenumi{\theenumi.}
\newcommand\labelenumii{(\theenumii)}
\newcommand\labelenumiii{\theenumiii.}
\newcommand\labelenumiv{\theenumiv.}
\renewcommand\p@enumii{\theenumi}
\renewcommand\p@enumiii{\theenumi(\theenumii)}
\renewcommand\p@enumiv{\p@enumiii\theenumiii}
\newcommand\labelitemi{\textbullet}
\newcommand\labelitemii{\normalfont\bfseries \textendash}
\newcommand\labelitemiii{\textasteriskcentered}
\newcommand\labelitemiv{\textperiodcentered}
\newenvironment{description}
               {\list{}{\labelwidth\z@ \itemindent-\leftmargin
                        \let\makelabel\descriptionlabel}}
               {\endlist}
\newcommand*\descriptionlabel[1]{\hspace\labelsep
                                \normalfont\bfseries #1}
\if@titlepage
  \newenvironment{abstract}{%
      \titlepage
      \null\vfil
      \@beginparpenalty\@lowpenalty
      \begin{center}%
        \bfseries \abstractname
        \@endparpenalty\@M
      \end{center}}%
     {\par\vfil\null\endtitlepage}
\else
  \newenvironment{abstract}{%
      \if@twocolumn
        \section*{\abstractname}%
      \else
        \small
        \begin{center}%
          {\bfseries \abstractname\vspace{-.5em}\vspace{\z@}}%
        \end{center}%
        \quotation
      \fi}
      {\if@twocolumn\else\endquotation\fi}
\fi
\newenvironment{verse}
               {\let\\\@centercr
                \list{}{\itemsep      \z@
                        \itemindent   -1.5em%
                        \listparindent\itemindent
                        \rightmargin  \leftmargin
                        \advance\leftmargin 1.5em}%
                \item\relax}
               {\endlist}
\newenvironment{quotation}
               {\list{}{\listparindent 1.5em%
                        \itemindent    \listparindent
                        \rightmargin   \leftmargin
                        \parsep        \z@ \@plus\p@}%
                \item\relax}
               {\endlist}
\newenvironment{quote}
               {\list{}{\rightmargin\leftmargin}%
                \item\relax}
               {\endlist}
\if@compatibility
\newenvironment{titlepage}
    {%
      \if@twocolumn
        \@restonecoltrue\onecolumn
      \else
        \@restonecolfalse\newpage
      \fi
      \thispagestyle{empty}%
      \setcounter{page}\z@
    }%
    {\if@restonecol\twocolumn \else \newpage \fi
    }
\else
\newenvironment{titlepage}
    {%
      \if@twocolumn
        \@restonecoltrue\onecolumn
      \else
        \@restonecolfalse\newpage
      \fi
      \thispagestyle{empty}%
      \setcounter{page}\@ne
    }%
    {\if@restonecol\twocolumn \else \newpage \fi
     \if@twoside\else
        \setcounter{page}\@ne
     \fi
    }
\fi
\newcommand\appendix{\par
  \setcounter{section}{0}%
  \setcounter{subsection}{0}%
  \renewcommand\thesection{\@Alph\c@section}}
\setlength\arraycolsep{5\p@}
\setlength\tabcolsep{6\p@}
\setlength\arrayrulewidth{.4\p@}
\setlength\doublerulesep{2\p@}
\setlength\tabbingsep{\labelsep}
\skip\@mpfootins = \skip\footins
\setlength\fboxsep{3\p@}
\setlength\fboxrule{.4\p@}
\renewcommand \theequation {\@arabic\c@equation}
\newcounter{figure}
\renewcommand \thefigure {\@arabic\c@figure}
\def\fps@figure{tbp}
\def\ftype@figure{1}
\def\ext@figure{lof}
\def\fnum@figure{\figurename~\thefigure}
\newenvironment{figure}
               {\@float{figure}}
               {\end@float}
\newenvironment{figure*}
               {\@dblfloat{figure}}
               {\end@dblfloat}
\newcounter{table}
\renewcommand\thetable{\@arabic\c@table}
\def\fps@table{tbp}
\def\ftype@table{2}
\def\ext@table{lot}
\def\fnum@table{\tablename~\thetable}
\newenvironment{table}
               {\@float{table}}
               {\end@float}
\newenvironment{table*}
               {\@dblfloat{table}}
               {\end@dblfloat}
\newlength\abovecaptionskip
\newlength\belowcaptionskip
\setlength\abovecaptionskip{10\p@}
\setlength\belowcaptionskip{0\p@}
\long\def\@makecaption#1#2{%
  \vskip\abovecaptionskip
  \sbox\@tempboxa{#1: #2}%
  \ifdim \wd\@tempboxa >\hsize
    #1: #2\par
  \else
    \global \@minipagefalse
    \hb@xt@\hsize{\hfil\box\@tempboxa\hfil}%
  \fi
  \vskip\belowcaptionskip}
\DeclareOldFontCommand{\rm}{\normalfont\rmfamily}{\mathrm}
\DeclareOldFontCommand{\sf}{\normalfont\sffamily}{\mathsf}
\DeclareOldFontCommand{\tt}{\normalfont\ttfamily}{\mathtt}
\DeclareOldFontCommand{\bf}{\normalfont\bfseries}{\mathbf}
\DeclareOldFontCommand{\it}{\normalfont\itshape}{\mathit}
\DeclareOldFontCommand{\sl}{\normalfont\slshape}{\@nomath\sl}
\DeclareOldFontCommand{\sc}{\normalfont\scshape}{\@nomath\sc}
\DeclareRobustCommand*\cal{\@fontswitch\relax\mathcal}
\DeclareRobustCommand*\mit{\@fontswitch\relax\mathnormal}
\newcommand\@pnumwidth{1.55em}
\newcommand\@tocrmarg{2.55em}
\newcommand\@dotsep{4.5}
\setcounter{tocdepth}{3}
\newcommand\tableofcontents{%
    \section*{\contentsname
        \@mkboth{%
           \MakeUppercase\contentsname}{\MakeUppercase\contentsname}}%
    \@starttoc{toc}%
    }
\newcommand*\l@part[2]{%
  \ifnum \c@tocdepth >-2\relax
    \addpenalty\@secpenalty
    \addvspace{2.25em \@plus\p@}%
    \begingroup
      \parindent \z@ \rightskip \@pnumwidth
      \parfillskip -\@pnumwidth
      {\leavevmode
       \large \bfseries #1\hfil \hb@xt@\@pnumwidth{\hss #2}}\par
       \nobreak
       \if@compatibility
         \global\@nobreaktrue
         \everypar{\global\@nobreakfalse\everypar{}}%
      \fi
    \endgroup
  \fi}
\newcommand*\l@section[2]{%
  \ifnum \c@tocdepth >\z@
    \addpenalty\@secpenalty
    \addvspace{1.0em \@plus\p@}%
    \setlength\@tempdima{1.5em}%
    \begingroup
      \parindent \z@ \rightskip \@pnumwidth
      \parfillskip -\@pnumwidth
      \leavevmode \bfseries
      \advance\leftskip\@tempdima
      \hskip -\leftskip
      #1\nobreak\hfil \nobreak\hb@xt@\@pnumwidth{\hss #2}\par
    \endgroup
  \fi}
\newcommand*\l@subsection{\@dottedtocline{2}{1.5em}{2.3em}}
\newcommand*\l@subsubsection{\@dottedtocline{3}{3.8em}{3.2em}}
\newcommand*\l@paragraph{\@dottedtocline{4}{7.0em}{4.1em}}
\newcommand*\l@subparagraph{\@dottedtocline{5}{10em}{5em}}
\newcommand\listoffigures{%
    \section*{\listfigurename
      \@mkboth{\MakeUppercase\listfigurename}%
              {\MakeUppercase\listfigurename}}%
    \@starttoc{lof}%
    }
\newcommand*\l@figure{\@dottedtocline{1}{1.5em}{2.3em}}
\newcommand\listoftables{%
    \section*{\listtablename
      \@mkboth{%
          \MakeUppercase\listtablename}{\MakeUppercase\listtablename}}%
    \@starttoc{lot}%
    }
\let\l@table\l@figure
\newdimen\bibindent
\setlength\bibindent{1.5em}
\newenvironment{thebibliography}[1]
     {\section*{\refname
        \@mkboth{\MakeUppercase\refname}{\MakeUppercase\refname}}%
      \list{\@biblabel{\@arabic\c@enumiv}}%
           {\settowidth\labelwidth{\@biblabel{#1}}%
            \leftmargin\labelwidth
            \advance\leftmargin\labelsep
            \@openbib@code
            \usecounter{enumiv}%
            \let\p@enumiv\@empty
            \renewcommand\theenumiv{\@arabic\c@enumiv}}%
      \sloppy
      \clubpenalty4000
      \@clubpenalty \clubpenalty
      \widowpenalty4000%
      \sfcode`\.\@m}
     {\def\@noitemerr
       {\@latex@warning{Empty `thebibliography' environment}}%
      \endlist}
\newcommand\newblock{\hskip .11em\@plus.33em\@minus.07em}
\let\@openbib@code\@empty
\newenvironment{theindex}
               {\if@twocolumn
                  \@restonecolfalse
                \else
                  \@restonecoltrue
                \fi
                \columnseprule \z@
                \columnsep 35\p@
                \twocolumn[\section*{\indexname}]%
                \@mkboth{\MakeUppercase\indexname}%
                        {\MakeUppercase\indexname}%
                \thispagestyle{plain}\parindent\z@
                \parskip\z@ \@plus .3\p@\relax
                \let\item\@idxitem}
               {\if@restonecol\onecolumn\else\clearpage\fi}
\newcommand\@idxitem{\par\hangindent 40\p@}
\newcommand\subitem{\@idxitem \hspace*{20\p@}}
\newcommand\subsubitem{\@idxitem \hspace*{30\p@}}
\newcommand\indexspace{\par \vskip 10\p@ \@plus5\p@ \@minus3\p@\relax}
\renewcommand\footnoterule{%
  \kern-3\p@
  \hrule\@width.4\columnwidth
  \kern2.6\p@}
\newcommand\@makefntext[1]{%
    \parindent 1em%
    \noindent
    \hb@xt@1.8em{\hss\@makefnmark}#1}
\newcommand\contentsname{Contents}
\newcommand\listfigurename{List of Figures}
\newcommand\listtablename{List of Tables}
\newcommand\refname{References}
\newcommand\indexname{Index}
\newcommand\figurename{Figure}
\newcommand\tablename{Table}
\newcommand\partname{Part}
\newcommand\appendixname{Appendix}
\newcommand\abstractname{Abstract}
\def\today{\ifcase\month\or
  January\or February\or March\or April\or May\or June\or
  July\or August\or September\or October\or November\or December\fi
  \space\number\day, \number\year}
\setlength\columnsep{10\p@}
\setlength\columnseprule{0\p@}
\pagestyle{plain}
\pagenumbering{arabic}
\if@twoside
\else
  \raggedbottom
\fi
\if@twocolumn
  \twocolumn
  \sloppy
  \flushbottom
\else
  \onecolumn
\fi

\def\cxpr{\hfill \setlength{\unitlength}{1mm}
\begin{picture}(0,0)(2.5,0)
\put(3,0){\framebox(2,2)}
\put(3.1,0){\line(0,2){2}}
\put(3.2,0){\line(0,2){2}}
\put(3.3,0){\line(0,2){2}}
\put(3.4,0){\line(0,2){2}}
\put(3.5,0){\line(0,2){2}}
\put(3.6,0){\line(0,2){2}}
\put(3.7,0){\line(0,2){2}}
\put(3.8,0){\line(0,2){2}}
\put(3.9,0){\line(0,2){2}}
\put(4,0){\line(0,2){2}}
\put(4.1,0){\line(0,2){2}}
\put(4.2,0){\line(0,2){2}}
\put(4.3,0){\line(0,2){2}}
\put(4.4,0){\line(0,2){2}}
\put(4.5,0){\line(0,2){2}}
\put(4.6,0){\line(0,2){2}}
\put(4.7,0){\line(0,2){2}}
\put(4.8,0){\line(0,2){2}}
\put(4.9,0){\line(0,2){2}}
\end{picture}}

\def\PCTEX{PCT\kern-.1667em\lower.5ex\hbox{E}\kern-.125emX}
\def\leqtil{<_{\phantom{x}_{\phantom{x}_{\hspace*{-6mm}\mbox{\normalsize $\sim$}}}}}
\def\cruzf{{\hspace*{2mm}{>\hspace*{-2,3mm}\lhd}}}
\def\aral{{{\it\it I}\hspace*{-1,3mm}\mbox{A}}}
\def\fff{\displaystyle\frac}
\def\hum{\hspace*{1mm}}
\def\hdois{\hspace*{2mm}}
\def\htres{\hspace*{3mm}}
\def\hquatro{\hspace*{4mm}}
\def\hcinco{\hspace*{5mm}}
\def\hdez{\hspace*{10mm}}
\def\hquinze{\hspace*{15mm}}
\def\hvinte{\hspace*{20mm}}
\def\centro{\begin{center}}
\def\fimcentro{\end{center}}
\def\vezes{$\times$}
\def\menos{$^{-}$}
\def\vum{\vspace*{1mm}}
\def\vdois{\vspace*{2mm}}
\def\vtres{\vspace*{3mm}}
\def\vquatro{\vspace*{4mm}}
\def\vcinco{\vspace*{5mm}}
\def\vseis{\vspace*{6mm}}
\def\vsete{\vspace*{7mm}}
\def\voito{\vspace*{8mm}}
\def\vdez{\vspace*{10mm}}
\def\vvinte{\vspace*{20mm}}
\def\im{\vspace*{3mm}\[}
\def\fm{\vspace*{3mm}\]}
\def\serg{\vspace*{5mm} \\ \hspace*{20mm}}
\def\hsf{\hspace*{\fill}}
\def\ddd{\displaystyle}
\def\vscm{\vspace{1cm}}
\def\sss{\displaystyle\sum}
\def\raiz{\displaystyle\sqrt}
\def\sen{\;\mbox{sen}\,}
\def\limi{\displaystyle\lim}
\def\mini{\displaystyle\min}
\def\qqq{{{Q\!\!\!\!l}}\phantom{.}}
\def\zzz{{{Z\!\!\!Z}}}
\def\ttt{{\cal T}}
\def\kkk{{\cal A}}
\def\hhh{{\cal H}}
\def\hreal{{I\!\!H}}
\def\jjj{{\cal J}}
\def\ggg{{\cal G}}
\def\anovo{{\bf A}}
\def\aga{I\hspace*{-1.3mm}H}
\def\abf{\mbox{\bf a}}
\def\bbb{{\backslash}}
\def\rrr{{I\!\!R}}
\def\ppp{{I\!\!P}}
\def\nnn{{{I\!\!N}}}
\def\igr{{{I\!\!I}}}
\def\ccc{{{C\!\!\!l\!}}\phantom{.}}
\def\estr{^{\ast}}
\def\ite{\displaystyle\int}
\def\arctg{\mbox{arc tag}}
\def\hcal{\mbox{\em H}}
\def\ucal{{\cal U}}
\def\defin{\stackrel{\rm def}{=}}
\def\fcal{{\cal F}}
\def\lcal{{\cal L}}
\def\pcal{\mbox{\it P}}
\def\acal{\mbox{\em a}}
\def\ocal{\mbox{\em o}}
\def\dcal{\mbox{\em D}}
\def\odin{{\cal O}}
\def\bcal{\mbox{\em B}}
\def\iii{{\in\!\!\!\!\!/}}
\def\subcort{\ddd\subseteq_{{\!\!\!\!/}}}
\def\cobr{\subset_{{\!\!\!\!\!\longrightarrow}}\,}
\def\primo{$^{\mbox{\underline{\small o}}}$\ }
\def\prima{$^{\mbox{\underline{\small a}}}$\ }
\def\creal{\mbox{C{\hspace*{-2mm}{\small I}}}}
\def\cao{\c{c}\~{a}o\ }
\def\oo{\'{o}}
\def\ooh{\'{o}\ }
\def\ee{\'{e}}
\def\aaa{\'{a}}
\def\ii{\'{\i}}
\def\ih{\'{\i}\ }
\def\coes{\c{c}\~{o}es\ }
\def\ou{\^{o}}
\def\ouh{\^{0}\ }
\def\ao{\~{a}o\ }
\def\aos{\~{a}os\ }
\def\eh{\'{e}\ }
\def\cc{\c{c}}
\def\oes{\~{o}es\ }
\def\eu{\^{e}}
\def\euh{\^{e}\ }
\def\aha{\`{a}\ }
\def\ah{\'{a}\ }
\def\an{\^{a}}
\def\uiu{\'{u}}
\def\trip{\mbox{
\setlength{\unitlength}{1mm}
\begin{picture}(4,2)(1,1)
\put(0,0){$\cdot$}
\put(2,0){$\cdot$}
\put(1,2){$\cdot$}
\end{picture}}}
\def\caixa{\hfill \setlength{\unitlength}{1mm}
\begin{picture}(2,2)(4,2)
\put(2,2){\framebox(2,2)}
\end{picture}}
\def\cxa{\setlength{\unitlength}{1mm}
\begin{picture}(2,2)(5,2)
\put(2,2){\framebox(2,2)}
\end{picture}}
\def\timbrado{
\noindent\setlength{\unitlength}{2mm}
\begin{picture}(4,0)(-75,-33)
\typeout{...}
\typeout{ ATENCAO !}
\typeout{ *** com TIMBRADO nao use o comando 
"topmargin"}
\typeout{ *** este documento saira' trimbrado(carta)  
(Vic/setembro/1995)}
\typeout{...}
\input{epic.sty}
\drawline( -3.95 ,-13.85641 )( -3.500 ,-14.38749 )
( -3.000,-14.83240 )( -2.500 ,-15.19868 )( -2.000 ,-15.49193 )
(-1.500 ,-15.71623 )( -1.000 ,-15.87451 )( -0.2,-16)
 
\drawline(0.21,-16)(  1.000 ,-15.87451 )(  1.500 ,-15.71623)
( 2.000 ,-15.49193 )(  2.500 ,-15.19868 )
(3.000,-14.83240 )(3.500,-14.38749)(4.000 ,-13.85641)
 
\drawline(4,-13.85641)(4,-17.5)(0.2,-17.5)
\drawline(-0.2,-17.5)(-4,-17.5)(-4,-13.85641)
\drawline(-0.2,-16)(-0.2,-17.5)
\drawline(0.2,-16)(0.2,-17.5)
%quadro superior
\drawline( -3.95 ,-13.35641 )( -3.500 ,-13.88749 )
(-3.000 ,-14.33240 )( -2.500 ,-14.69868 )( -2.000 ,-14.99193)
(-1.500 ,-15.21623 )( -1.000 ,-15.37451 )( -0.2,-15.5)
 
\drawline(0.21,-15.5)(  1.000 ,-15.37451 )(  1.500 ,-15.21623)
(  2.000 ,-14.99193 )(  2.500 ,-14.69868 )(  3.000,-14.33240 )
(  3.500 ,-13.88749 )(  4.000 ,-13.35641)
 
\drawline(4,-13.35641)(4,-13)(0.21,-13)
\drawline(-4,-13.35641)(-4,-13)(-0.2,-13)

\drawline(-0.2,-13)(-0.2,-15.5)
\drawline(0.2,-13)(0.2,-15.5)
\put(-81.70,-16){
\scriptsize
\begin{tabular}{l}
{\normalsize\bf Funda\cao Universidade de Bras\'{\i}lia} \\
{\bf Departamento de Matem\'atica - IE} 
\end{tabular}}
\put(-80.6,-20){
\scriptsize
Campus Universit\'ario, 
70910-900 - Bras\'{\i}lia - DF}
\put(-26,-20){ 
\scriptsize
Fone: (061) 273-3356 -- 
 FAX: (061) 274-3910}
\drawline(-80,-18)(4,-18)
\end{picture}\vspace*{-10mm}\\ }
\def\mattipo{
\noindent\setlength{\unitlength}{1.6mm}
\begin{picture}(8,5)(-3,-17.5)
\typeout{...}
\typeout{ ATENCAO !}
\typeout{ *** este e' um logotipo com "UnB-IE-MAT"
medindo: 13x7mm}
\typeout{ *** (Vicente/janeiro/1996)}
\typeout{...}
\input{epic.sty}
\put(-1.8,-14.7){\scriptsize UnB}
\put(-3.3,-17.3){\scriptsize IE-MAT}
\drawline( -3.95 ,-13.85641 )( -3.500 ,-14.38749 )
( -3.000,-14.83240 )( -2.500 ,-15.19868 )( -2.000 ,-15.49193 )
(-1.500 ,-15.71623 )( -1.000 ,-15.87451 )( -0.2,-16)
\drawline(0.21,-16)(  1.000 ,-15.87451 )(  1.500 ,-15.71623)
( 2.000 ,-15.49193 )(  2.500 ,-15.19868 )
(3.000,-14.83240 )(3.500,-14.38749)(4.000 ,-13.85641)
\drawline(4,-13.85641)(4,-17.5)(0.2,-17.5)
\drawline(-0.2,-17.5)(-4,-17.5)(-4,-13.85641)
\drawline(-0.2,-17.1)(-0.2,-17.5)
\drawline(0.2,-16)(0.2,-16.5)
\drawline(0.2,-17.3)(0.2,-17.5)
\drawline( -3.95 ,-13.35641 )( -3.500 ,-13.88749 )
(-3.000 ,-14.33240 )( -2.500 ,-14.69868 )( -2.000 ,-14.99193)
(-1.500 ,-15.21623 )( -1.000 ,-15.37451 )( -0.2,-15.5)
\drawline(0.21,-15.5)(  1.000 ,-15.37451 )(  1.500 ,-15.21623)
(  2.000 ,-14.99193 )(  2.500 ,-14.69868 )(  3.000,-14.33240 )
(  3.500 ,-13.88749 )(  4.000 ,-13.35641)
\drawline(4,-13.35641)(4,-13)(0.21,-13)
\drawline(-4,-13.35641)(-4,-13)(-0.2,-13)
\drawline(-0.2,-13)(-0.2,-13.5)
\drawline(-0.2,-14.9)(-0.2,-15.5)
\drawline(0.2,-13)(0.2,-13.5)
\drawline(0.2,-14.9)(0.2,-15.5)
\end{picture}}
\def\Mattipo{
\noindent\setlength{\unitlength}{2.6mm}
\begin{picture}(8,5)(-3,-17.5)
\typeout{...}
\typeout{ ATENCAO !}
\typeout{ *** este e' um logotipo com "UnB-IE-MAT"
medindo: 21x12mm}
\typeout{ *** (Vicente/janeiro/1996)}
\typeout{...}
\input{epic.sty}
\put(-1.6,-14.7){UnB}
\put(-2.9,-17.3){\small IE}
\put(0.4,-17.3){\small MAT}
\drawline( -3.95 ,-13.85641 )( -3.500 ,-14.38749 )
( -3.000,-14.83240 )( -2.500 ,-15.19868 )( -2.000 ,-15.49193 )
(-1.500 ,-15.71623 )( -1.000 ,-15.87451 )( -0.2,-16)
\drawline(0.21,-16)(  1.000 ,-15.87451 )(  1.500 ,-15.71623)
( 2.000 ,-15.49193 )(  2.500 ,-15.19868 )
(3.000,-14.83240 )(3.500,-14.38749)(4.000 ,-13.85641)
\drawline(4,-13.85641)(4,-17.5)(0.2,-17.5)
\drawline(-0.2,-17.5)(-4,-17.5)(-4,-13.85641)
\drawline(-0.2,-16)(-0.2,-17.5) 
\drawline(0.2,-16)(0.2,-17.5) 
\drawline( -3.95 ,-13.35641 )( -3.500 ,-13.88749 )
(-3.000 ,-14.33240 )( -2.500 ,-14.69868 )( -2.000 ,-14.99193)
(-1.500 ,-15.21623 )( -1.000 ,-15.37451 )( -0.2,-15.5)
\drawline(0.21,-15.5)(  1.000 ,-15.37451 )(  1.500 ,-15.21623)
(  2.000 ,-14.99193 )(  2.500 ,-14.69868 )(  3.000,-14.33240 )
(  3.500 ,-13.88749 )(  4.000 ,-13.35641)
\drawline(4,-13.35641)(4,-13)(0.21,-13)
\drawline(-4,-13.35641)(-4,-13)(-0.2,-13)
\drawline(-0.2,-13)(-0.2,-13.5)
\drawline(-0.2,-14.9)(-0.2,-15.5)
\drawline(0.2,-13)(0.2,-13.5)
\drawline(0.2,-14.9)(0.2,-15.5)
\end{picture}}
\def\cxpr{\hfill \setlength{\unitlength}{1mm}
\begin{picture}(0,0)(2.5,0)
\put(3,0){\framebox(2,2)}
\put(3.1,0){\line(0,2){2}}
\put(3.2,0){\line(0,2){2}}
\put(3.3,0){\line(0,2){2}}
\put(3.4,0){\line(0,2){2}}
\put(3.5,0){\line(0,2){2}}
\put(3.6,0){\line(0,2){2}}
\put(3.7,0){\line(0,2){2}}
\put(3.8,0){\line(0,2){2}}
\put(3.9,0){\line(0,2){2}}
\put(4,0){\line(0,2){2}}
\put(4.1,0){\line(0,2){2}}
\put(4.2,0){\line(0,2){2}}
\put(4.3,0){\line(0,2){2}}
\put(4.4,0){\line(0,2){2}}
\put(4.5,0){\line(0,2){2}}
\put(4.6,0){\line(0,2){2}}
\put(4.7,0){\line(0,2){2}}
\put(4.8,0){\line(0,2){2}}
\put(4.9,0){\line(0,2){2}}
\end{picture}}
\def\mensu{\setlength{\unitlength}{1mm}
\begin{picture}(4,0)(1,1.5)
\input{epic.sty}
	\put(0,1.8){\em m}      
	\drawline(3.5,2.5)(3.6,3)(3.7,3.5)(3.8,3.7)(3.7,3.7)(3.5,3.9)
	(3.4,4)(3.2,4.2)(3,4.25)(2.5,4.4)(2.25,4.4)(2.3,4.4)(1.5,4.35)
	(1.25,4.25)(1,4.2)(0.75,4.1)(0.6,4)(0.5,3.9)(0.25,3.7)
	(0.1,3.5)(0,3.25)(-0.2,2.5)(0,2)(0.25,1.25)(0.5,1.4)(1,1)
	(1.5,0.8)(2,0.8)(2.25,0.9)(2.5,1)(3,1.25)
\end{picture}}
\def\inabla{
\setlength{\unitlength}{1mm}
\begin{picture}(4,3)(0,0)
\input{epic.sty}
\put(0,0){$\nabla$}
\drawline(1,0.1)(-0.4,2.75)
\end{picture}}
\endinput
%%
%% End of file `artigo.cls'.
