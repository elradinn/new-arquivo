import { FormEventHandler, useEffect } from "react";
import { useForm } from "@inertiajs/react";
import { notifications } from "@mantine/notifications";
import { NumberingSchemeResourceData } from "../Types/NumberingSchemeResourceData";
import { UpdateNumberingSchemeData } from "../Types/UpdateNumberingSchemeData";

interface UseUpdateNumberingSchemeProps {
    initialData?: NumberingSchemeResourceData;
    close: () => void;
}

export function useUpdateNumberingScheme({ initialData, close }: UseUpdateNumberingSchemeProps) {
    const { data, setData, post, patch, processing, errors, reset } = useForm<UpdateNumberingSchemeData>({
        name: "",
        prefix: "",
    });

    useEffect(() => {
        if (initialData) {
            setData({
                name: initialData.name,
                prefix: initialData.prefix,
            });
        }
    }, [initialData]);

    const handleSubmit: FormEventHandler = (e) => {
        e.preventDefault();

        const routeName = initialData ? "numbering-scheme.update" : "numbering-scheme.store";
        const method = initialData ? patch : post;

        method(route(routeName, initialData?.id), {
            onSuccess: () => {
                close();
                notifications.show({
                    message: `Numbering scheme ${initialData ? "updated" : "created"} successfully`,
                    color: "green",
                });
            },
            onError: (errors) => {
                console.log(errors);
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