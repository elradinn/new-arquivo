import React, { FormEventHandler, useEffect } from "react";
import { Button, Flex, Modal, Select, Stack, Text, TextInput } from "@mantine/core";
import { useForm } from "@inertiajs/react";
import { notifications } from "@mantine/notifications";
import { Metadata } from "@/types";

interface IProps {
    isOpened: boolean;
    close: () => void;
    metadata?: Metadata;
}

const EditMetadataForm: React.FC<IProps> = ({ isOpened, close, metadata }) => {
    const { data, setData, patch, processing, errors, reset } = useForm<
        Omit<Metadata, "id">
    >({
        name: "",
        description: "",
        type: "",
    });

    useEffect(() => {
        if (metadata) {
            setData({
                name: metadata.name,
                description: metadata.description,
                type: metadata.type,
            });
        }
    }, [metadata]);

    const editmetadataubmit: FormEventHandler = (e) => {
        e.preventDefault();

        patch(route("metadata.update", metadata?.id), {
            onSuccess: () => {
                close();
                notifications.show({
                    message: "Metadata edited successfully",
                    color: "green",
                });
            },

            onFinish: () => reset(),
        });
    };

    return (
        <Modal
            opened={isOpened}
            onClose={close}
            title={<Text size="lg">Edit Metadata</Text>}
            size={550}
        >
            <form onSubmit={editmetadataubmit}>
                <Stack gap={16}>
                    <TextInput
                        id="name"
                        type="text"
                        name="name"
                        value={data.name}
                        label="Name"
                        onChange={(e) => setData("name", e.target.value)}
                        error={errors.name}
                    />

                    <TextInput
                        id="description"
                        type="text"
                        name="description"
                        value={data.description}
                        label="Description"
                        onChange={(e) => setData("description", e.target.value)}
                        error={errors.description}
                    />

                    <Select
                        label="Type"
                        placeholder="Choose Type"
                        value={data.type}
                        onChange={(_value, option) => setData("type", option.value)}
                        error={errors.type}
                        data={["String", "Boolean", "Datetime"]}
                    />
                </Stack>

                <Flex align="center" justify="end" mt={16}>
                    <Button variant="outline" onClick={close}>
                        Cancel
                    </Button>

                    <Button ml={12} type="submit" loading={processing}>
                        Save
                    </Button>
                </Flex>
            </form>
        </Modal>
    );
};

export default EditMetadataForm;