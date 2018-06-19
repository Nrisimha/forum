<?php

$at["__meta"]["default"] = [
  "language" => "tr",
  "file" => __FILE__,
  "version" => "1.0",
  "date" => "4 Mar 2017",
  "author" => "Metehan Arslan"
];

$at["test_text_without_a_variable"] = "Değişkensiz yazı testi";
$at["test_text_with_VAR_variable"] = "Değişkeni var:'%var%' olan yazı testi";

$at["there_are_NUMBER_cats"] = 
[
  "number" => [
    "var" => "number",
    "rule" => "plural",
    "if_one" => "There is a cat!",
    "if_many" => "There are %number% cats!"
  ]
];

$at["there_are_NUMBER_cats_playing_at_HUMANS_garden_and_she_loves_watching_it"] =
[
  "_text" => "§npart1§ §part2§",
  "part1" => [
    "var" => "number",
    "rule" => "plural",
    "if_one" => "There is a cat playing at",
    "if_many" => "There are %number% cats playing at"
  ],
  "part2" => [
    "var" => "sex",
    "rule" => "selector",
    "male" => "%human%'s garden and he loves watching it.",
    "female" => "%human%'s garden and she loves watching it.",
    "trans" => "%human%'s garden and nhe loves watching it."
  ]
];

$at["there_are_NUMBER_cats_playing_at_HUMANS_garden_and_she_loves_watching_it"] =
[
  "_text" => "There §number§ playing at %human%'s garden and §sex§ loves watching it.",
  "number" => [
    "var" => "number",
    "rule" => "plural",
    "if_one" => "is a cat",
    "if_many" => "are %number% cats"
  ],
  "sex" => [
    "var" => "sex",
    "rule" => "selector",
    "male" => "he",
    "female" => "she",
    "trans" => "nhe"
  ]
];

return $at;