module Commands exposing (..)

import Http
import Json.Decode as Decode
import Json.Decode.Pipeline exposing (decode, required)
import Messages exposing (Msg)
import Models exposing (User)
import RemoteData


getUser : Cmd Msg
getUser =
    Http.get fetchUserUrl userDecoder
        |> RemoteData.sendRequest
        |> Cmd.map Messages.OnFetchUser


fetchUserUrl : String
fetchUserUrl =
    "/desk/main/getuser"


userDecoder : Decode.Decoder User
userDecoder =
    decode User
        |> required "id" Decode.int
        |> required "name" Decode.string
        |> required "email" Decode.string
