module Pages.SingleTicket.View exposing (..)

import Array
import Char
import Html exposing (..)
import Html.Attributes exposing (..)
import Html.Events exposing (onClick)
import Pages.SingleTicket.Messages exposing (..)
import Pages.SingleTicket.Model exposing (..)
import RemoteData


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
                    ([ div [ class "media m-b-30 p-t-20" ]
                        (renderUserDetails model)
                     ]
                        ++ renderTicketBody model
                        ++ [ renderAllMessages model ]
                        ++ [ hr []
                                []
                           , div [ class "b-all p-20" ]
                                [ p [ class "p-b-20" ]
                                    [ text "click here to Reply"
                                    ]
                                ]
                           ]
                    )
                ]
            ]
        ]


renderUserDetails : Model -> List (Html Msg)
renderUserDetails { ticket } =
    case ticket of
        RemoteData.Success ticketReady ->
            [ h4 [ class "font-bold m-t-0" ]
                [ text ticketReady.subject ]
            , hr []
                []
            , a [ class "pull-left", href "#" ]
                [ img [ class "media-object thumb-sm img-circle", src "../plugins/images/users/pawandeep.jpg", alt "" ]
                    []
                ]
            , div [ class "media-body" ]
                [ span [ class "media-meta pull-right" ]
                    [ text (toString ticketReady.date) ]
                , h4 [ class "text-danger m-0" ]
                    [ text ticketReady.user ]
                , small [ class "text-muted" ]
                    [ text ("Agent: " ++ ticketReady.handler_agent) ]
                ]
            ]

        _ ->
            [ div [ class "sk-chasing-dots" ]
                [ div [ class "sk-child sk-dot1" ] [], div [ class "sk-child sk-dot2" ] [] ]
            ]


renderTicketBody : Model -> List (Html Msg)
renderTicketBody { ticket } =
    case ticket of
        RemoteData.Success ticketReady ->
            List.append
                [ p []
                    [ text (getMessage ticketReady) ]
                , hr []
                    []
                ]
                (renderAttachments ticketReady)

        RemoteData.Failure e ->
            Debug.log (toString e)
                [ div [ class "sk-chasing-dots" ]
                    [ div [ class "sk-child sk-dot1" ] [], div [ class "sk-child sk-dot2" ] [] ]
                ]

        _ ->
            [ div [ class "sk-chasing-dots" ]
                [ div [ class "sk-child sk-dot1" ] [], div [ class "sk-child sk-dot2" ] [] ]
            ]


renderAllMessages : Model -> Html Msg
renderAllMessages { ticket, messagesTab } =
    div []
        [ ul [ class "nav customtab nav-tabs" ]
            [ li [ class "nav-item" ]
                [ a [ href "javascript:void(0)", class ("nav-link " ++ isTabActive messagesTab Messages), onClick (OnMessagesTab Messages) ]
                    [ span [ class "visible-xs" ]
                        [ i [ class "ti-home" ]
                            []
                        ]
                    , span [ class "hidden-xs" ]
                        [ text "Messages" ]
                    ]
                ]
            , li [ class "nav-item" ]
                [ a [ href "javascript:void(0)", class ("nav-link " ++ isTabActive messagesTab TeamDiscussion), onClick (OnMessagesTab TeamDiscussion) ]
                    [ span [ class "visible-xs" ]
                        [ i [ class "ti-user" ]
                            []
                        ]
                    , span [ class "hidden-xs" ]
                        [ text "Team Discussion" ]
                    ]
                ]
            ]
        , div [ class "tab-content" ]
            [ getTabContent ticket messagesTab
            ]
        ]


getTabContent : RemoteData.WebData Ticket -> MessagesTab -> Html Msg
getTabContent ticket messagesTab =
    case messagesTab of
        Messages ->
            div [ class "tab-pane fade active in" ]
                [ renderMessages ticket
                ]

        TeamDiscussion ->
            div [ class "tab-pane fade active in" ]
                [ renderTeamMessages ticket
                ]


renderMessages : RemoteData.WebData Ticket -> Html Msg
renderMessages ticket =
    case ticket of
        RemoteData.Success ticketReady ->
            ul [ class "timeline" ]
                (List.map
                    renderMessage
                    ticketReady.messages
                )

        _ ->
            div [ class "sk-chasing-dots" ]
                [ div [ class "sk-child sk-dot1" ] [], div [ class "sk-child sk-dot2" ] [] ]


renderTeamMessages : RemoteData.WebData Ticket -> Html Msg
renderTeamMessages ticket =
    case ticket of
        RemoteData.Success ticketReady ->
            ul [ class "timeline" ]
                (List.map
                    renderMessage
                    ticketReady.team_discuss
                )

        _ ->
            div [ class "sk-chasing-dots" ]
                [ div [ class "sk-child sk-dot1" ] [], div [ class "sk-child sk-dot2" ] [] ]


renderMessage : Message -> Html Msg
renderMessage message =
    li
        [ class
            (if message.user == "you" then
                ""
             else
                "timeline-inverted"
            )
        ]
        [ div [ class "timeline-badge success" ]
            [ img [ class "img-responsive", alt "user", src "../plugins/images/users/genu.jpg" ]
                []
            ]
        , div [ class "timeline-panel" ]
            [ div [ class "timeline-heading" ]
                [ h4 [ class "timeline-title" ]
                    [ text message.user ]
                , p []
                    [ small [ class "text-muted" ]
                        [ i [ class "fa fa-clock-o" ]
                            []
                        , text (toString message.date)
                        ]
                    ]
                ]
            , div [ class "timeline-body" ]
                [ p []
                    [ text message.message ]
                ]
            ]
        ]


isTabActive : MessagesTab -> MessagesTab -> String
isTabActive messageTab expected =
    if messageTab == expected then
        "active"
    else
        ""


getMessage : Ticket -> String
getMessage { custom_fields } =
    let
        message =
            custom_fields
                |> List.filter (\f -> f.key == "message")
                |> Array.fromList
    in
    case Array.get 0 message of
        Just message ->
            message.values

        Nothing ->
            ""


renderAttachments : Ticket -> List (Html Msg)
renderAttachments { custom_fields } =
    let
        message =
            custom_fields
                |> List.filter (\f -> f.key == "attach")

        messagesLength =
            List.length message
    in
    if messagesLength > 0 then
        [ h4 []
            [ i [ class "fa fa-paperclip m-r-10 m-b-10" ]
                []
            , text "Attachments"
            , span []
                [ text ("(" ++ toString messagesLength ++ ")") ]
            ]
        , div [ class "row" ]
            (List.map renderAttachment message)
        ]
    else
        [ h4 []
            [ i [ class "fa fa-paperclip m-r-10 m-b-10" ]
                []
            , text "Attachments"
            , span []
                [ text "(0)" ]
            ]
        , div [ class "row" ] []
        ]


renderAttachment : CustomField -> Html Msg
renderAttachment attach =
    div [ class "col-sm-2 col-xs-4" ]
        [ a [ href "javascript:void(0)" ]
            [ img [ class "img-thumbnail img-responsive", alt "attachment", src attach.values ]
                []
            ]
        ]


renderSideLabels : Model -> List (Html Msg)
renderSideLabels { ticket } =
    case ticket of
        RemoteData.Success data ->
            List.map renderSideLabel data.tags

        _ ->
            [ div [ class "sk-chasing-dots" ]
                [ div [ class "sk-child sk-dot1" ] [], div [ class "sk-child sk-dot2" ] [] ]
            ]


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
