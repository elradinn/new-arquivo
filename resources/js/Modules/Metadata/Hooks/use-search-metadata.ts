import { useState } from "react";
import { router } from "@inertiajs/react";

export function useMetadataSearch(initialSearch: string = "") {
    const [search, setSearch] = useState(initialSearch);

    const handleSearch = (search: string) => {
        setSearch(search);
        router.get("/metadata", { search }, { preserveState: true, replace: true });
    };

    return { search, setSearch, handleSearch };
}