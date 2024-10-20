import axios from "axios";
import { useState, useEffect } from "react";
import { UserResourceData } from "@/Modules/User/Types/UserResourceData";
import { NumberingSchemeResourceData } from "../Types/NumberingSchemeResourceData";

export function useFetchNumberingScheme(numberingSchemeId?: string) {
    const [numberingScheme, setNumberingScheme] = useState<NumberingSchemeResourceData | null>(null);

    useEffect(() => {
        if (numberingSchemeId) {
            fetchNumberingScheme(numberingSchemeId);
        }
    }, [numberingSchemeId]);

    const fetchNumberingScheme = async (numberingSchemeId: string) => {
        try {
            const response = await axios.get(`/numbering-scheme/api/${numberingSchemeId}`);
            setNumberingScheme(response.data);
        } catch (error) {
            console.error("Error fetching numbering scheme", error);
        }
    };

    return numberingScheme;
}