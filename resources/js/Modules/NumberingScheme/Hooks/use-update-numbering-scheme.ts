import { FormEventHandler, useEffect } from "react";
import { useForm } from "@inertiajs/react";
import { notifications } from "@mantine/notifications";
import { NumberingSchemeResourceData } from "../Types/NumberingSchemeResourceData";
import { UpdateNumberingSchemeData } from "../Types/UpdateNumberingSchemeData";
import { ItemParentResourceData } from "@/Modules/Item/Types/ItemParentResourceData";
import { useFetchNumberingScheme } from "./use-fetch-numbering-scheme";
import useModalStore from "@/Modules/Common/Hooks/use-modal-store";

interface UseUpdateNumberingSchemeProps {
    itemParent?: ItemParentResourceData;
}

export function useUpdateNumberingScheme({ itemParent }: UseUpdateNumberingSchemeProps) {
    const numberingScheme = useFetchNumberingScheme(itemParent?.numbering_scheme_id);

    const { data, setData, put, processing, errors, reset } = useForm<UpdateNumberingSchemeData>({
        name: "",
        prefix: "",
    });

    const { closeModal } = useModalStore();

    useEffect(() => {
        setData({
            name: numberingScheme?.name || "",
            prefix: numberingScheme?.prefix || "",
        });
    }, [numberingScheme]);

    const handleSubmit: FormEventHandler = (e) => {
        e.preventDefault();

        const routeName = "numbering-scheme.update";

        put(route(routeName, itemParent?.numbering_scheme_id), {
            onSuccess: () => {
                closeModal("updateNumberingScheme");
                notifications.show({
                    message: `Numbering scheme updated successfully`,
                    color: "green",
                });
            },
            onError: (errors) => {
                notifications.show({
                    message: "Something went wrong",
                    color: "red",
                });
            },
            onFinish: () => reset(),
        });
    };

    return { data, setData, handleSubmit, processing, errors };
}