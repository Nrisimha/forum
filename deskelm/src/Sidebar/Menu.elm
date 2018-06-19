module Sidebar.Menu exposing (..)

import Html exposing (..)
import Html.Attributes exposing (class, href)
import Routing exposing(getRouteByName)

-- Build Menu Functions and aliases


type MenuItem
    = MenuItem
        { href : String
        , icon : String
        , text : String
        , numberLabel : Int
        , children : ChildrenMenuItem
        , active : Bool
        }


type alias ChildrenMenuItem =
    { children : List MenuItem, class : String }


noChildren : ChildrenMenuItem
noChildren =
    { children = [], class = "" }


menuItem : String -> String -> ChildrenMenuItem -> String -> Int -> MenuItem
menuItem href text children icon numberLabel =
    MenuItem
        { href = href
        , icon = icon
        , text = text
        , numberLabel = numberLabel
        , children = children
        , active = False
        }


menuItemChildren : String -> String -> ChildrenMenuItem -> MenuItem
menuItemChildren href text children =
    menuItem href text children "" 0



-- Create Menu Here


menu : List MenuItem
menu =
    [ menuItem (.dashboard getRouteByName) "Dashboard" noChildren "zmdi zmdi-copy zmdi-hc-fw fa-fw" 0
    ---, menuItem "javascript:void(0)" "Tickets" (ticketChildren "nav-second-level") "zmdi zmdi-copy zmdi-hc-fw fa-fw" 2
    , menuItem getRouteByName.ticketView "Tickets" noChildren "zmdi zmdi-copy zmdi-hc-fw fa-fw" 2
    ]


--ticketChildren : String -> ChildrenMenuItem
--ticketChildren class =
--    { class = class
--    , children =
--        [ menuItemChildren getRouteByName.ticketAnswer "Answer" noChildren
--        , menuItemChildren getRouteByName.ticketCreate "Create" noChildren
--        ]
--    }



--- Render Functions


renderLinks { menu } =
    List.map renderLink menu


renderChildren { children } =
    ul [ class ("nav " ++ children.class) ]
        (List.map renderChild children.children)


renderChild : MenuItem -> Html msg
renderChild menuItem =
    case menuItem of
        MenuItem item ->
            li
                []
                [ a [ href item.href, class (isActive item) ]
                    [ text item.text, span [ class (arrowIcon item) ] [] ]
                , renderChildren item
                ]


arrowIcon { children } =
    if List.length children.children == 0 then
        ""
    else
        "fa arrow"


isActive { active } =
    if active then
        "active"
    else
        ""


renderLink : MenuItem -> Html msg
renderLink menuItem =
    case menuItem of
        MenuItem item ->
            li []
                [ a [ href item.href, class ("waves-effect " ++ isActive item) ]
                    [ i [ class item.icon ]
                        []
                    , span [ class "hide-menu" ]
                        [ text item.text
                        , span [ class (arrowIcon item) ] []
                        , if item.numberLabel > 0 then
                            span [ class "label label-rouded label-purple pull-right" ] [ text (toString item.numberLabel) ]
                          else
                            span [] []
                        ]
                    ]
                , renderChildren item
                ]
