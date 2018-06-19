module Pages.Tickets.View exposing (..)

import Array
import Char
import Html exposing (..)
import Html.Attributes exposing (..)
import Pages.Tickets.Messages exposing (..)
import Pages.Tickets.Model exposing (..)
import RemoteData
import Set
import Routing exposing(getRouteByName)

view : Model -> Html Msg
view model =
    div [ class "col-md-12" ]
        [ div [ class "white-box" ]
            [ div [ class "row" ]
                [ div [ class "col-lg-2 col-md-3  col-sm-12 col-xs-12 inbox-panel" ]
                    [ div []
                        [ a [ href "javascript:void(0)", class "btn btn-custom btn-block waves-effect waves-light" ]
                            [ text "Compose" ]
                        , div [ class "list-group mail-list m-t-20" ]
                            [ a [ href "javascript:void(0)", class "list-group-item active" ]
                                [ text "Inbox"
                                , span [ class "label label-rouded label-success pull-right" ]
                                    [ text "5" ]
                                ]
                            , a [ href "javascript:void(0)", class "list-group-item " ]
                                [ text "Starred" ]
                            , a [ href "javascript:void(0)", class "list-group-item" ]
                                [ text "Draft"
                                , span [ class "label label-rouded label-warning pull-right" ]
                                    [ text "15" ]
                                ]
                            , a [ href "javascript:void(0)", class "list-group-item" ]
                                [ text "Sent Mail" ]
                            , a [ href "javascript:void(0)", class "list-group-item" ]
                                [ text "Trash"
                                , span [ class "label label-rouded label-default pull-right" ]
                                    [ text "55" ]
                                ]
                            ]
                        , h3 [ class "panel-title m-t-40 m-b-0" ]
                            [ text "Labels" ]
                        , hr [ class "m-t-5" ]
                            []
                        , div [ class "list-group b-0 mail-list" ]
                            (renderSideLabels model)
                        ]
                    ]
                , div [ class "col-lg-10 col-md-9 col-sm-12 col-xs-12 mail_listing" ]
                    [ div [ class "inbox-center" ]
                        [ table [ class "table table-hover" ]
                            [ thead []
                                [ tr []
                                    [ th [ width 30 ]
                                        [ div [ class "checkbox m-t-0 m-b-0 " ]
                                            [ input [ id "checkbox0", type_ "checkbox", class "checkbox-toggle", value "check all" ]
                                                []
                                            , label [ for "checkbox0" ]
                                                []
                                            ]
                                        ]
                                    , th [ colspan 4 ]
                                        [ div [ class "btn-group" ]
                                            [ button [ type_ "button", class "btn btn-primary dropdown-toggle waves-effect waves-light m-r-5" ]
                                                [ text "Filter"
                                                , b [ class "caret" ]
                                                    []
                                                ]
                                            , ul [ class "dropdown-menu" ]
                                                [ li []
                                                    [ a [ href "javascript:void(0)" ]
                                                        [ text "Read" ]
                                                    ]
                                                , li []
                                                    [ a [ href "javascript:void(0)" ]
                                                        [ text "Unread" ]
                                                    ]
                                                , li []
                                                    [ a [ href "javascript:void(0)" ]
                                                        [ text "Something else here" ]
                                                    ]
                                                , li [ class "divider" ]
                                                    []
                                                , li []
                                                    [ a [ href "javascript:void(0)" ]
                                                        [ text "Separated link" ]
                                                    ]
                                                ]
                                            ]
                                        , div [ class "btn-group" ]
                                            [ button [ type_ "button", class "btn btn-default waves-effect waves-light  dropdown-toggle" ]
                                                [ i [ class "fa fa-refresh" ]
                                                    []
                                                ]
                                            ]
                                        ]
                                    , th [ class "hidden-xs", width 100 ]
                                        [ div [ class "btn-group pull-right" ]
                                            [ button [ type_ "button", class "btn btn-default waves-effect" ]
                                                [ i [ class "fa fa-chevron-left" ]
                                                    []
                                                ]
                                            , button [ type_ "button", class "btn btn-default waves-effect" ]
                                                [ i [ class "fa fa-chevron-right" ]
                                                    []
                                                ]
                                            ]
                                        ]
                                    ]
                                ]
                            , renderView model
                            ]
                        ]
                    , div [ class "row" ]
                        [ div [ class "col-xs-7 m-t-20" ]
                            [ text "Showing 1 - 15 of 200" ]
                        , div [ class "col-xs-5 m-t-20" ]
                            [ div [ class "btn-group pull-right" ]
                                [ button [ type_ "button", class "btn btn-default waves-effect" ]
                                    [ i [ class "fa fa-chevron-left" ]
                                        []
                                    ]
                                , button [ type_ "button", class "btn btn-default waves-effect" ]
                                    [ i [ class "fa fa-chevron-right" ]
                                        []
                                    ]
                                ]
                            ]
                        ]
                    ]
                ]
            ]
        ]


renderView : Model -> Html Msg
renderView { tickets } =
    case tickets of
        RemoteData.Success data ->
            renderTickets data

        _ ->
            div [ class "sk-chasing-dots" ]
                [ div [ class "sk-child sk-dot1" ] [], div [ class "sk-child sk-dot2" ] [] ]


renderTickets : List Ticket -> Html Msg
renderTickets tickets =
    tbody []
        (List.map renderTicket tickets)


renderTicket : Ticket -> Html Msg
renderTicket ticket =
    tr [ class "unread" ]
        [ td []
            [ div [ class "checkbox m-t-0 m-b-0" ]
                [ input [ type_ "checkbox" ]
                    []
                , label [ for "checkbox0" ]
                    []
                ]
            ]
        , td [ class "hidden-xs" ]
            [ i [ class "fa fa-star text-warning" ]
                []
            ]
        , td [ class "hidden-xs" ]
            [ text ticket.user ]
        , td [ class "max-texts" ]
            [ a [ href (getRouteByName.ticketView ++ (toString ticket.id))]
                (List.append (renderLabels ticket.tags) [ text ticket.subject ])
            ]
        , td [ class "hidden-xs" ]
            [ i [ class "fa fa-paperclip" ]
                []
            ]
        , td [ class "text-right" ]
            [ text (toString ticket.last_date) ]
        ]


renderLabels : List String -> List (Html Msg)
renderLabels tags =
    tags
        |> List.take 2
        |> List.map renderLabel


renderLabel : String -> Html Msg
renderLabel label =
    span
        [ class ("label m-r-10 label-" ++ getLabelClass label) ]
        [ text label ]


renderSideLabel : String -> Html Msg
renderSideLabel label =
    a [ href "javascript:void(0)", class "list-group-item" ]
        [ span [ class ("fa fa-circle m-r-10 text-" ++ getLabelClass label) ]
            []
        , text label
        ]


getLabelClass : String -> String
getLabelClass text =
    let
        labelClassesLength =
            Array.length labelClasses

        textNumber =
            text
                |> String.toList
                |> List.map Char.toCode
                |> List.foldr (+) 2

        labelIndex =
            textNumber % labelClassesLength
    in
    case Array.get labelIndex labelClasses of
        Just label ->
            label

        Nothing ->
            "info"


labelClasses : Array.Array String
labelClasses =
    Array.fromList [ "info", "warning", "purple", "danger", "success" ]


renderSideLabels : Model -> List (Html Msg)
renderSideLabels { tickets } =
    case tickets of
        RemoteData.Success data ->
            data
                |> findAllTags
                |> List.map renderSideLabel

        _ ->
            [ div [ class "sk-chasing-dots" ]
                [ div [ class "sk-child sk-dot1" ] [], div [ class "sk-child sk-dot2" ] [] ]
            ]


findAllTags : List Ticket -> List String
findAllTags tickets =
    tickets
        |> List.map (\ticket -> ticket.tags)
        |> List.concat
        |> Set.fromList
        |> Set.toList
